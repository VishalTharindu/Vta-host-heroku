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

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Applicant $applicant)
    {
        $applicants = Applicant::get();
        $batches = Batch::get();
        $maleCount = $applicant->maleCount($applicants);
        $femaleCount = $applicant->femaleCount($applicants);
        return view('applicant.index', compact('applicants','batches','maleCount','femaleCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::select('id','course_name')->get();
        $batches = Batch::get();
        //return view('applicant.create', compact('courses','batches'));
        $applicant = new Applicant();
        if($applicant->BatchInInterview()){
            $interviewMode = True;
            return view('applicant.create', compact('courses','batches','interviewMode'));
        }else{
            $interviewMode = False;
            return view('applicant.create', compact('courses','batches','interviewMode'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApplicantRequest $request)
    {
        $validated = $request->validated();        

        $applicant = new Applicant;
        $applicant->batch_id = request('batch_id');
        $applicant->full_name = request('full_name');
        $applicant->name_with_initials = request('name_with_initials');
        $applicant->nic = request('nic');
        $applicant->email = request('email');
        $applicant->gender = request('gender');
        $applicant->ethnicity = request('ethnicity');
        $applicant->phone_number = request('phone_number');
        $applicant->address = request('address');
        $applicant->city = request('city');
        $applicant->qualification = request('qualification');
        $applicant->save();

        if($request->courses){
            $applicant->courses()->attach($request->courses);
        }

        if($applicant->BatchInInterview()){
            $interviewMode = True;
            return redirect()->route('interview.index')->withStatus(__('New Applicant Added Successfully'));
        }else{
            $interviewMode = False;
            return redirect()->route('applicant.index')->withStatus(__('New Applicant Added Successfully'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function show(Applicant $applicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function edit(Applicant $applicant)
    {
        $courses = Course::select('id','course_name')->get();
        $batches = Batch::get();
        
        $batch = $applicant->getbatch($applicant->batch_id);
        if($batch->interview_status == 1 || $batch->interview_status == 2 || $batch->interview_status == 3 || $batch->interview_status == 4){
            
            if(Auth::user()->hasRole('ma') && $batch->interview_status == 1){
                $interviewMode = True;
                return view('applicant.edit', compact('applicant','courses','batches','interviewMode'));
            }
            elseif(Auth::user()->hasRole('mr') && $batch->interview_status == 2){
                $interviewMode = True;
                return view('applicant.edit', compact('applicant','courses','batches','interviewMode'));
            }
            else{
                return redirect()->route('applicant.index')->withError(__('This applicant is in an ongoing interview process'));
            }
        }else{
            $interviewMode = False;
            return view('applicant.edit', compact('applicant','courses','batches','interviewMode'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function update(ApplicantRequest $request, Applicant $applicant)
    {
        $validated = $request->validated();
        
        $applicant->batch_id = request('batch_id');
        $applicant->full_name = request('full_name');
        $applicant->name_with_initials = request('name_with_initials');
        $applicant->nic = request('nic');
        $applicant->email = request('email');
        $applicant->gender = request('gender');
        $applicant->ethnicity = request('ethnicity');
        $applicant->phone_number = request('phone_number');
        $applicant->address = request('address');
        $applicant->city = request('city');
        $applicant->qualification = request('qualification');
        
        //If the applicant is a selected user, selected course is changed
        if($applicant->status == 1){
            $applicant->selected_course_id = request('selected_course_id');
        }
        $applicant->save();

        if($request->courses){
            $applicant->courses()->sync($request->courses);
        }

        $batch = $applicant->getbatch($applicant->batch_id);
        if(Auth::user()->hasRole('ma') && $batch->interview_status == 1){
            return redirect()->route('interview.index')->withStatus(__('Applicant Data Updated Successfully'));
        }
        elseif(Auth::user()->hasRole('mr') && $batch->interview_status == 2){
            return redirect()->route('interview.index')->withStatus(__('Applicant Data Updated Successfully'));
        }
        else{
            return redirect()->route('applicant.index')->withStatus(__('Applicant Data Updated Successfully'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Applicant $applicant)
    {
        $batch = $applicant->getbatch($applicant->batch_id);
        if($batch->interview_status == 1 || $batch->interview_status == 2 || $batch->interview_status == 3){

            if(Auth::user()->hasRole('ma') && $batch->interview_status != 1){
                return redirect()->route('applicant.index')->withError(__('You cannot delete, Applicant in interview process'));
            }
            elseif(Auth::user()->hasRole('mr')){
                return redirect()->route('applicant.index')->withError(__('You cannot delete, Applicant in interview process'));
            }
            elseif(Auth::user()->hasRole('oic')){
                return redirect()->route('applicant.index')->withError(__('You cannot delete, Applicant in interview process'));
            }

            $applicant->courses()->detach($applicant->courses);
            $applicant->delete();
            return redirect()->route('interview.index')->withStatus(__('Applicant successfully deleted.'));
        
        }else{

            $applicant->courses()->detach($applicant->courses);
            $applicant->delete();
            return redirect()->route('applicant.index')->withStatus(__('Applicant successfully deleted.'));
        }
        
    }

    /**
     * Filter Applicant Data according to course and batch
     *
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function filterData(Applicant $applicant){

        $filterBatch = request('filterBatch');

        $batches = Batch::get();

        if($filterBatch == 0){

            return redirect()->route('applicant.index');

        }
        else{

            $applicants = Applicant::where([
                ['batch_id', '=', $filterBatch],
            ])->get();
                $batch = Batch::where('id',$filterBatch)->first();
            $maleCount = $applicant->maleCount($applicants);
            $femaleCount = $applicant->femaleCount($applicants);
            return view('applicant.index', compact('applicants','batches','batch','filterBatch','maleCount','femaleCount'));
        }


    }

    /**
     * Deleting the remaining applicants after the interview
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function applicantsDelete($id){
        
        if(Auth::user()->hasRole('mr')){

            $batch = Batch::where('id',$id)->first();

            if($batch->interview_status == 5){
                
                $applicants = Applicant::where('batch_id',$id)->get();

                foreach($applicants as $applicant){
                    
                    $applicant->courses()->detach($applicant->courses);
                    $applicant->delete();
                    
                }

                return redirect()->route('applicant.index')->withStatus(__('You have successfully deleted the applicants of the batch.'));

            }
            elseif($batch->interview_status == 0){
            
                return redirect()->route('applicant.index')->withError(__('Interview is not yet done for this batch'));
            }
            else{

                return redirect()->route('applicant.index')->withError(__('Interview is in progress for this batch'));
            }
        }

        return redirect()->route('home');
        
    }


}