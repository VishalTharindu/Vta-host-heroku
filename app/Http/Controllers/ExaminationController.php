<?php

namespace App\Http\Controllers;

use App\Examination;
use App\Trainee;
use App\Batch;
use App\Course;
use App\Subject;
use App\Mark;
use App\Attendance;
use App\ExaminationPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  Wirtten Examination Related Function
    public function index()
    {
        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.checkeligibility', compact('courses','batchs'));
        
    }

    public function eligibleListForExam(){

        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');
       
        $reCourseName = Course::find($requiredCourse)->course_name;
        $reBatchName = Batch::find($requiredBatch);

        $trainees = Trainee::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['ojt_letter_issued', '!=', 0]])->get();
        
        return view('examination.eligiblelist', compact('courses','batchs','trainees','requiredCourse','requiredBatch','reCourseName', 'reBatchName'));
    }
    public function markSubjectView()
    {
        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.marksubject', compact('courses','batchs'));
        
    }

    function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table('subjects')
          ->where($select, $value)
          ->get();
        $output = '<option value="">Subjects</option>';
        foreach($data as $row)
        {
         $output .= '<option value="'.$row->$dependent.'">'.$row->subject_name .'</option>';
        }
        echo $output;
       
    }

    public function subjectTrainee(Request $request){

        $courses = Course::get();
        $batchs  = Batch::get();

        $requiredCourse = request('course');
        $requiredBatch = request('batch');
        $subject = request('subjects');

        $requiredSubject = Subject::where('id', '=' ,$subject)->get();

        $trainees = Trainee::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['ojt_letter_issued', '!=', 0]])->get();
        return view('examination.addmarkes', compact('courses','batchs','trainees','requiredCourse','requiredBatch','requiredSubject','subject'));

        
    }

    public function traineeFinalList(){

        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.setexamstatus', compact('courses','batchs'));
    }

    public function markTraineefinalresult(Request $request){

        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');

        $subjects = Subject::where('course_id', '=' ,$requiredCourse)->get();
        $subjectCount = count($subjects);
        $trainees = Trainee::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['ojt_letter_issued', '!=', 0]])->get();
        return view('examination.setexamstatus', compact('courses','batchs','trainees','requiredCourse','requiredBatch','subjects', 'subjectCount'));

    }

    
    public function markTraineeFinalResultStore(Request $request){

        $course = request('course');
        $batch = request('batch');
        $status = request('status');
        $test = 0;
        $type = "W";

        $trainees = Trainee::where([['course_id', '=', $course], ['batch_id', '=', $batch], ['ojt_letter_issued', '!=', 0]])->get();

        if (!empty($trainees)) {

            foreach ($trainees as $trainee) {

                $Traineestatus = Examination::traineePassFailStatus($trainee->id);
                $precentage = Attendance::calculateAttendanceEligibility($trainee->id);
                $paiedtrainees = ExaminationPayment::paiedTrainess($trainee->id);

                if (($Traineestatus == 1) && ($precentage >= 80) && ($paiedtrainees == 1)) {

                    $prvresult = Examination::where([['trainee_id', '=' ,$trainee->id], ['course_id', '=', $course],['batch_id', '=', $batch]])->orderBy('created_at','desc')->first();

                    $attempt = $request->rows[$trainee->id]['attempt'];

                    if (!empty($status)) {

                        $examresult = new Examination;
                        $examresult->trainee_id  = $trainee->id;
                        $examresult->course_id  = $course;
                        $examresult->batch_id  = $batch;
                        $examresult->type  = $type;
    
                        if (in_array($trainee->id, $status)) {
                            $examresult->status  = 1;
                        }else {
                            $examresult->status  = 0;
                        }
                        
                        $examresult->attempt = $attempt;
                        $examresult->save();                   
                    }else {

                        $examresult = new Examination;
                        $examresult->trainee_id  = $trainee->id;
                        $examresult->course_id  = $course;
                        $examresult->batch_id  = $batch;
                        $examresult->type  = $type;
                        $examresult->status  = 0;
                        $examresult->attempt = $attempt;
                        $examresult->save();
                }
                }
            }
        }

        return redirect()->action('ExaminationController@traineeFinalList')->withStatus(__('Result has been marked successfully'));
        
    }


    public function checkFinalResult(){

        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.result', compact('courses','batchs'));

    }

    public function checkAttemptResult(){

        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.attemptwiseresult', compact('courses','batchs'));

    }

    public function finalResult(){

        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');

        $reCourseName = Course::find($requiredCourse)->course_name;
        $reBatchName = Batch::find($requiredBatch);

        $pass = Examination::calculatePassPrecentage($requiredCourse, $requiredBatch);
        $fail = Examination::calculateFailPrecentage($requiredCourse, $requiredBatch);

        $subjects = Subject::where('course_id', '=' ,$requiredCourse)->get();

        $traineeResult = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch]])->pluck('trainee_id');
        $trainees = Trainee::whereIn('id', $traineeResult)->get();
        return view('examination.result', compact('courses','batchs','trainees','requiredCourse','requiredBatch','subjects','pass','fail','reCourseName','reBatchName'));
    }

    public function attemptWiseResult(){

       
        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');
        $studentId = request('stdId');
        $studentNic = request('stdNic');

        if ($studentId == null && $studentNic == null) {
            return redirect()->action('ExaminationController@checkAttemptResult')->withError(__('You need to give NIC or Enrollement number'));
        }
       

        if ($studentNic != null) {
            $traineesid = Trainee::where('nic', '=', $studentNic)->pluck('id');
            $trainees = Trainee::where('nic', '=', $studentNic)->get();           
        }else{
            $traineesid = Trainee::where('enrollment_no', '=', $studentId)->pluck('id');
            $trainees = Trainee::where('enrollment_no', '=', $studentId)->get();
        }

        // $pass = Examination::calculatePassPrecentage($requiredCourse, $requiredBatch);
        // $fail = Examination::calculateFailPrecentage($requiredCourse, $requiredBatch);
       
        $subjects = Subject::where('course_id', '=' ,$requiredCourse)->get();
        if (count($traineesid) > 0) {
            $traineeResult = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['trainee_id', '=', $traineesid], ['type', '=', 'W']])->get();          
            return view('examination.attemptwiseresult', compact('courses','batchs','trainees','requiredCourse','requiredBatch','traineeResult','subjects'));
        }
       return back(); 

    }

    public function checkPracticalAttemptResult(){

        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.practicalattemtsresult', compact('courses','batchs'));

    }

    public function practicalAttemptWiseResult(){

       
        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');
        $studentId = request('stdId');
        $studentNic = request('stdNic');

        if ($studentId == null && $studentNic == null) {
            return redirect()->action('ExaminationController@checkAttemptResult')->withError(__('You need to give NIC or Enrollement number'));
        }
        // $pass = Examination::calculatePassPrecentage($requiredCourse, $requiredBatch);
        // $fail = Examination::calculateFailPrecentage($requiredCourse, $requiredBatch);
        if ($studentNic != null) {
            $traineesid = Trainee::where('nic', '=', $studentNic)->pluck('id');
            $trainees = Trainee::where('nic', '=', $studentNic)->get();           
        }else{
            $traineesid = Trainee::where('enrollment_no', '=', $studentId)->pluck('id');
            $trainees = Trainee::where('enrollment_no', '=', $studentId)->get();
        }

        $subjects = Subject::where('course_id', '=' ,$requiredCourse)->get();

        if (count($traineesid) > 0) {

        $traineeResult = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['trainee_id', '=', $traineesid], ['type', '=', 'P']])->get();
        return view('examination.practicalattemtsresult', compact('courses','batchs','trainees','requiredCourse','requiredBatch','traineeResult','subjects'));

        }
        return back();

    }


    // Practical Examination Related Function

    public function practicalEligibilityIndex()
    {
        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.practicaleligibilitylist', compact('courses','batchs'));
        
    }

    public function eligibleListForPracticalExam(){

        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');
        $subjects = Subject::where('course_id', '=' ,$requiredCourse)->get();

        $reCourseName = Course::find($requiredCourse)->course_name;
        $reBatchName = Batch::find($requiredBatch);
        
        $traineeResult = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['status', '=', 1]])->orderBy('created_at','desc')->pluck('trainee_id');
        $trainees = Trainee::whereIn('id', $traineeResult)->get();
        return view('examination.practicaleligibilitylist', compact('courses','batchs','trainees','requiredCourse','requiredBatch','subjects','reCourseName','reBatchName'));
    }

    public function traineePracticalFinalList(){

        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.addpracticalresult', compact('courses','batchs'));
    }

    public function markTraineefinalPractiaclresult(Request $request){

        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');

        $subjects = Subject::where('course_id', '=' ,$requiredCourse)->get();
        $subjectCount = count($subjects);
        $traineeResult = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['type', '=', "W"], ['status', '=', 1]])->orderBy('created_at','desc')->pluck('trainee_id');
        $trainees = Trainee::whereIn('id', $traineeResult)->get();
        return view('examination.addpracticalresult', compact('courses','batchs','trainees','requiredCourse','requiredBatch','subjects', 'subjectCount'));

    }

    public function markTraineeFinalPracticalResultStore(Request $request){

        $course = request('course');
        $batch = request('batch');
        $status = request('status');
        $test = 0;
        $type = "P";

        $traineeResult = Examination::where([['course_id', '=', $course], ['batch_id', '=', $batch], ['type', '=', "W"], ['status', '=', 1]])->orderBy('created_at','desc')->pluck('trainee_id');
        $trainees = Trainee::whereIn('id', $traineeResult)->get();

        if (!empty($trainees)) {

            foreach ($trainees as $trainee) {

                $curntstatus = Examination::traineePracticlStatus($trainee->id);

                $prvresult = Examination::where([['trainee_id', '=' ,$trainee->id], ['course_id', '=', $course],['batch_id', '=', $batch]])->orderBy('created_at','desc')->first();

                if ($curntstatus == 0) {
                    $attempt = $request->rows[$trainee->id]['attempt'];
    
                    if (!empty($status)) {
    
                        $examresult = new Examination;
                        $examresult->trainee_id  = $trainee->id;
                        $examresult->course_id  = $course;
                        $examresult->batch_id  = $batch;
                        $examresult->type  = $type;
    
                        if (in_array($trainee->id, $status)) {
                            $examresult->status  = 1;
                        }else {
                            $examresult->status  = 0;
                        }
                        
                        $examresult->attempt = $attempt;
                        $examresult->save();                   
                    }else {
    
                        $examresult = new Examination;
                        $examresult->trainee_id  = $trainee->id;
                        $examresult->course_id  = $course;
                        $examresult->batch_id  = $batch;
                        $examresult->type  = $type;
                        $examresult->status  = 0;
                        $examresult->attempt = $attempt;
                        $examresult->save();
                    }
                }
            }
        }

        return redirect()->action('ExaminationController@traineePracticalFinalList')->withStatus(__('Result has been marked successfully'));
        
    }

    public function checkOverallResult(){

        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.finalresult', compact('courses','batchs'));

    }

    public function OveerallResult(){

        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');

        $reCourseName = Course::find($requiredCourse)->course_name;
        $reBatchName = Batch::find($requiredBatch);

        $pass = Examination::calculatePassPrecentageFinal($requiredCourse, $requiredBatch);
        $fail = Examination::calculateFailPrecentageFinal($requiredCourse, $requiredBatch);

        $subjects = Subject::where('course_id', '=' ,$requiredCourse)->get();

        $traineeResult = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['type', '=', 'P']])->pluck('trainee_id');
        $trainees = Trainee::whereIn('id', $traineeResult)->get();
        return view('examination.finalresult', compact('courses','batchs','trainees','requiredCourse','requiredBatch','subjects','pass','fail','reCourseName','reBatchName'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function show(Examination $examination)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function edit(Examination $examination)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Examination $examination)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Examination  $examination
     * @return \Illuminate\Http\Response
     */
    public function destroy(Examination $examination)
    {
        //
    }
}
