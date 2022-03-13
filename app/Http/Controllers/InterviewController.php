<?php

namespace App\Http\Controllers;

use App\Applicant;
use App\Course;
use App\Batch;
use App\User;
use App\Trainee;
use jeremykenedy\LaravelRoles\Models\Role as Role;
use Illuminate\Support\Facades\Notification;
use App\Notifications\notificationTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ApplicantRequest;
use App\Http\Requests\ApplicantSelectRequest;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{

/* 
******************************************************************************************************************
    Interview Process is controlled with the field 'interview_status' in the batches table

    interview_status = 1 means Management Assistant has selected a batch to start the interview proccess
    interview_status = 2 means Management Assistant has sent the selected applicants of particular batch list to
                         Management Representative to review the selected applicants
    interview_status = 3 means Management Representative has sent the reviewed list to OIC to review
    interview_status = 4 means OIC reviewed and process accepted and send back to Managemant Asisstant
                         (data of applicants table move to trainees table)
    After filling up the other details of the selected applicants, MA finish the whole process by making
    interview_status to 5. (In TraineeController)

    Roles
        ma - Management Assistant
        mr - Management Representative
        OIC - Officer in Charge 
******************************************************************************************************************    
*/

    /**
     * Display the interview page
     *
     * @return \Illuminate\Http\Response
     */
    public function interview(Applicant $applicant){

        if (Auth::user()->hasRole('mr') && !Batch::where('interview_status', 2)->orWhere('interview_status', 3)->first()) {

            return redirect()->route('home')->withError(__('There is no ongoing interview process'));
        }
        elseif (Auth::user()->hasRole('mr') && Batch::where('interview_status', 3)->first()){

            return redirect()->route('home')->withStatus(__('You have already reviewed the interview process'));

        }
        elseif (Auth::user()->hasRole('oic') && !Batch::where('interview_status', 3)->first()){

            return redirect()->route('home')->withError(__('There is no ongoing interview process'));

        }
        elseif (Auth::user()->hasRole('ma') && Batch::where('interview_status', 2)->orWhere('interview_status', 3)->first()){

            return redirect()->route('home')->withError(__('Interview is in reviewing process'));

        }
        elseif (Auth::user()->hasRole('ma') && Batch::where('interview_status', 4)->first()){

            return redirect()->route('home')->withError(__('You still have to update the previous selected trainee data'));

        }
        elseif(Auth::user()->hasRole('ma') || Auth::user()->hasRole('mr') || Auth::user()->hasRole('oic')){

            if(Auth::user()->unreadNotifications->count() > 0){
                Auth::user()->unreadNotifications->markAsRead();
            }
            
            $batch=$applicant->BatchInInterview();

            //If any batch is in interview mode with needed data
            if($applicant->BatchInInterview()){
                $interviewMode = True;
                if (Auth::user()->hasRole('mr') || Auth::user()->hasRole('oic')){
                    return view('interview.index', [
                        'applicants' => $applicant->where([
                            ['batch_id', '=', $batch->id],
                            ['status', '=', 1],
                        ])->get(),
                        'courses' => Course::select('id','course_name')->get(),
                        'batches' => Batch::orderBy('created_at', 'DESC')->get(),
                        'selectedBatch' => $batch,
                        'interviewMode' => $interviewMode
                        ]);
                }

                $selectedApplicantCount=$applicant->selectedApplicants(0)->count();
                return view('interview.index', [
                    'applicants' => $applicant->where('batch_id',$batch->id)->get(),
                    'courses' => Course::select('id','course_name')->get(),
                    'batches' => Batch::orderBy('created_at', 'DESC')->get(),
                    'selectedBatch' => $batch,
                    'interviewMode' => $interviewMode,
                    'selectedApplicantCount' => $selectedApplicantCount
                    ]);
                    
            }
            //Redirect to the same page but with interviewMode variable in FALSE.
            else{
                $interviewMode = FALSE;
                return view('interview.index', [
                    'batches' => Batch::orderBy('created_at', 'DESC')->get(),
                    'interviewMode' => $interviewMode
                    ]);
            }
        }else{
            return redirect()->route('home');
        }

        
    }

    /**
     * Batch for the interview is selected
     *
     * @return \Illuminate\Http\Response
     */
    public function interviewBatchSelect(Request $request,Applicant $applicant){

        if(Auth::user()->hasRole('ma')){

            $batch = Batch::where('id',$request->batch_id)->first();

            if($batch->interview_status == 5){

                return redirect()->route('interview.index')->withError(__('You have already conducted an interview process for this batch'));
            }

            Batch::where('id', $request->batch_id)
            ->update(['interview_status' => 1]);

            $batch=$applicant->BatchInInterview();
            return redirect()->route('interview.index');
        }

        return redirect()->route('home');
        
    }

    /**
     * Change the interview_status back to 0 to change the batch to start the interview process
     *
     * @return \Illuminate\Http\Response
     */
    public function interviewBatchChange(){

        if(Auth::user()->hasRole('ma')){

            Batch::where('interview_status', 1)
            ->update(['interview_status' => 0]);
            //$interviewMode = FALSE;

            Applicant::where('status', 1)
            ->update([
                'status' => 0,
                'selected_course_id' => 0
                ]);
            return redirect()->route('interview.index');
        }

        return redirect()->route('home');
    }

    /**
     * Applicant Select for a particular course.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function applicantSelect(ApplicantSelectRequest $request,Applicant $applicant){

        if(Batch::where('interview_status', 1)->first() && Auth::user()->hasRole('ma')){
            $validated = $request->validated();
            $name = $applicant->name_with_initials;
            $CourseID = $request->course_id;
            $course = Course::where('id',$CourseID)->first();
            Applicant::where('id', $applicant->id)
                    ->update(['status' => 1,'selected_course_id' => $CourseID]);
            
            return redirect()->route('interview.index')->withStatus(__('You have selected :- '.$name.' for '.$course->course_name));
        }else{
            return redirect()->route('home');
        }
        
        
    }

    /**
     * Unselect the selected user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function applicantUnselect(Applicant $applicant){

        if(Batch::where('interview_status', 1)->first() && Auth::user()->hasRole('ma')){
            Applicant::where('id', $applicant->id)
                ->update(['status' => 0,'selected_course_id' => 0]);
            return redirect()->route('interview.index')->withStatus(__('You have unselected the user'));
        }else{
            return redirect()->route('interview.index')->withError(__('Interview is in reviewing process'));
        }
        
    }

    /**
     * Selected Applicant Reject by OIC
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function applicantReject(Request $request,Applicant $applicant){

        if($applicant->rejected_reason == NULL){

            $validatedData = $request->validate([
                'rejected_reason' => 'required|min:5',
            ]);
    
            Applicant::where('id', $applicant->id)->update([
                'rejected_reason' => request('rejected_reason')
                ]);
            
            return redirect()->route('interview.index')->withStatus(__('You have successfully rejected the applicant'));
        }
        else{

            Applicant::where('id', $applicant->id)->update([
                'rejected_reason' => NULL
                ]);
            
            return redirect()->route('interview.index')->withStatus(__('You have successfully selected back the applicant'));
        }
        
    }

    /**
     * MA view the OIC rejected list of the interview process
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function rejected(){

        if(Batch::where('interview_status', 4)->first()){
            $batch=Batch::where('interview_status', 4)->first();

            $applicants = Applicant::where([
                ['batch_id', '=', $batch->id],
                ['status', '=', 1],
                ['rejected_reason', '!=', NULL],
            ])->get();
            
            
            return view('interview.toTrainee', compact('applicants'));
            
        }
        return redirect()->route('home');
    }
    
    /**
     * Interview process is over and MA sent the selected applcants for MR to review with a notification
     *
     * @return \Illuminate\Http\Response
     */
    public function notificationToMR(){

        if(Auth::user()->hasRole('ma')){

            if(Batch::where('interview_status', 2)->first()){
                return redirect()->route('interview.index')->withError(__('In Reviewing Process'));
            }
            elseif(Batch::where('interview_status', 1)->first()){
                $applicant = new Applicant();

                if($applicant->selectedApplicants(0)->count() == 0){
                    return redirect()->route('interview.index')->withError(__('You have not selected any applicants'));
                }
                
                $batch=$applicant->BatchInInterview();
                $MR = Role::where('name','=','MR')->first();

                Batch::where('interview_status', 1)
                        ->update(['interview_status' => 2]);

                Notification::send($MR->users, new notificationTo($batch));

                return redirect()->route('home')->withStatus(__('Successfully sent the selected batch list to review. Once reviewed by MR and OIC you will receive a notification'));
            }else{

                return redirect()->route('home');

            }
            
        }

        return redirect()->route('home');
    }

    /**
     * MR reiew and accept the selected applicants and send the data to OIC with a notification
     *
     * @return \Illuminate\Http\Response
     */
    public function notificationToOIC(){

        if(Auth::user()->hasRole('mr')){
            if(Batch::where('interview_status', 3)->first()){
                return redirect()->route('interview.index')->withError(__('Already Sent to Review Process'));
            }
            elseif(Batch::where('interview_status', 2)->first()){

                $applicant = new Applicant();
                $batch=$applicant->BatchInInterview();
                $MR = Role::where('name','=','OIC')->first();
                
                Batch::where('interview_status', 2)
                ->update(['interview_status' => 3]);

                Notification::send($MR->users, new notificationTo($batch));

                return redirect()->route('home')->withStatus(__('You have accepted the selected batch and sent to OIC to review'));

            }else{
                return redirect()->route('home');
            }
        }
        return redirect()->route('home');

    }

    /**
     * OIC confirm the batch and move selected data frm applicants table to trainees table with a notification to MA
     *
     * @return \Illuminate\Http\Response
     */
    public function oicConfirm(){

        if(Auth::user()->hasRole('oic')){

            if(Batch::where('interview_status', 4)->first()){
                return redirect()->route('home')->withError(__('Already confirmed the interview process'));
            }
            elseif(Batch::where('interview_status', 3)->first()){

                $applicant = new Applicant();
                $batch=$applicant->BatchInInterview();
                $MA = Role::where('name','=','ma')->first();
                $applicants = Applicant::where([
                    ['batch_id', '=', $batch->id],
                    ['status', '=', 1],
                    ['rejected_reason', '=', NULL],
                ])->get();
                    
                foreach($applicants as $applicant){

                    $trainee = new Trainee;
                    $trainee->course_id = $applicant->selected_course_id;
                    $trainee->batch_id = $applicant->batch_id;
                    $trainee->full_name = $applicant->full_name;
                    $trainee->name_with_initials = $applicant->name_with_initials;
                    $trainee->nic = $applicant->nic;
                    $trainee->email = $applicant->email;
                    $trainee->gender = $applicant->gender;
                    $trainee->ethnicity = $applicant->ethnicity;
                    $trainee->phone_number = $applicant->phone_number;
                    $trainee->address = $applicant->address;
                    $trainee->city = $applicant->city;
                    $trainee->status = 1;
                    $trainee->qualification = $applicant->qualification;

                    if($trainee->save()){
                        $applicant->courses()->detach($applicant->courses);
                        $applicant->delete();
                    }

                }
                Batch::where('interview_status', 3)
                            ->update(['interview_status' => 4]);

                Notification::send($MA->users, new notificationTo($batch));

                return redirect()->route('home')->withStatus(__('You have confirmed the batch selected list'));

            }else{
                return redirect()->route('home');
            }

        }

        return redirect()->route('home');
    }

    /**
     * After accepting of OIC, MA gets this page to update other data of seleted trainee
     *
     * @return \Illuminate\Http\Response
     */
    public function toTraineeView(Trainee $trainee){
        
        $trainees = Trainee::where('status',1)->get();

        if(Batch::where('interview_status', 4)->first() && $trainees->count() > 0){

            Auth::user()->unreadNotifications->markAsRead();

            $batch=Batch::where('interview_status', 4)->first();

            $trainees = Trainee::where([
                ['batch_id', '=', $batch->id],
                ['status', '=', 1],
            ])->get();
            
            $courses = Course::get();
            
            return view('interview.toTrainee', compact('trainees','courses'));
            
        }
        return redirect()->route('home')->withError(__('No trainee data to update'));
        

    }

    
    /**
     * Filter the inteview data according to course and display data for MR and OIC
     *
     * @return \Illuminate\Http\Response
     */
    public function filterCourse(Applicant $applicant){

        $filteredCourse = request('filtercourse');
        $batch=$applicant->BatchInInterview();

        if(Auth::user()->hasRole('mr') || Auth::user()->hasRole('oic')){
            $interviewMode = True;
            if($filteredCourse == 0){
                return redirect()->route('interview.index');
            }

            $courseName = Course::where('id',$filteredCourse)->first()->course_name;
            return view('interview.index', [
                'applicants' => $applicant->where([
                    ['batch_id', '=', $batch->id],
                    ['status', '=', 1],
                    ['selected_course_id', '=', $filteredCourse],
                ])->get(),
                'courses' => Course::select('id','course_name')->get(),
                'batches' => Batch::orderBy('created_at', 'DESC')->get(),
                'selectedBatch' => $batch,
                'interviewMode' => $interviewMode,
                'filteredCourse' => $filteredCourse,
                'courseName' => $courseName
                ]);
        }
        elseif(Auth::user()->hasRole('ma') ){

            //batch in where MA need update the selected trainee data (last step in interview process)
            $batchstatusUpdate = Batch::where('interview_status', 4)->first();

            //batch status where MA need to select applicants
            $batchstatusInterview = Batch::where('interview_status', 1)->first();

            if($batchstatusUpdate){
                
                if($filteredCourse == 0){
                    return redirect()->route('interview.updateTrainee');
                }
                
                $trainees = Trainee::where([
                    ['batch_id', '=', $batchstatusUpdate->id],
                    ['status', '=', 1],
                    ['course_id', '=', $filteredCourse],
                ])->get();
                
                $courses = Course::get();
                return view('interview.toTrainee', compact('trainees','courses','filteredCourse'));
            }
            elseif($batchstatusInterview){
                $interviewMode = True;
                if($filteredCourse == 0){
                    return redirect()->route('interview.index');
                }

                $courseName = Course::where('id',$filteredCourse)->first()->course_name;
                $selectedApplicantCount=$applicant->selectedApplicants($filteredCourse)->count();
                return view('interview.index', [
                    'applicants' => $applicant->where([
                        ['batch_id', '=', $batch->id],
                        ['status', '=', 1],
                        ['selected_course_id', '=', $filteredCourse],
                    ])->get(),
                    'courses' => Course::select('id','course_name')->get(),
                    'batches' => Batch::orderBy('created_at', 'DESC')->get(),
                    'selectedBatch' => $batch,
                    'interviewMode' => $interviewMode,
                    'filteredCourse' => $filteredCourse,
                    'courseName' => $courseName,
                    'selectedApplicantCount' => $selectedApplicantCount
                    ]);
            }

        }
        
        return redirect()->route('home');
    }
}