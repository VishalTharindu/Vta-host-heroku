<?php

namespace App\Http\Controllers;

use App\PreAssesmentRsult;
use App\Trainee;
use App\Batch;
use App\Course;
use App\Subject;
use Appp\PreAssesmentMark;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PreAssesmentRsultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::get();
        $batchs  = Batch::get();

        return view('preeassesment.checkeligibility', compact('courses','batchs'));
        
    }

    public function eligibleListForExam(){

        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');

        $trainees = Trainee::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch]])->get();
        return view('preeassesment.eligiblelist', compact('courses','batchs','trainees','requiredCourse','requiredBatch'));
    }
    public function markSubjectView()
    {
        $courses = Course::get();
        $batchs  = Batch::get();

        return view('preeassesment.marksubject', compact('courses','batchs'));
        
    }

    function prefetch(Request $request)
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

    public function presubjectTrainee(Request $request){

        $courses = Course::get();
        $batchs  = Batch::get();

        $requiredCourse = request('course');
        $requiredBatch = request('batch');
        $subject = request('subjects');

        $requiredSubject = Subject::where('id', '=' ,$subject)->get();

        $trainees = Trainee::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch]])->get();
        return view('preeassesment.addmarkes', compact('courses','batchs','trainees','requiredCourse','requiredBatch','requiredSubject','subject'));

        
    }

    public function traineeFinalList(){

        $courses = Course::get();
        $batchs  = Batch::get();

        return view('preeassesment.setexamstatus', compact('courses','batchs'));
    }

    public function markTraineefinalresult(Request $request){

        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');

        $subjects = Subject::where('course_id', '=' ,$requiredCourse)->get();
        $subjectCount = count($subjects);
        $trainees = Trainee::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch]])->get();
        return view('preeassesment.setexamstatus', compact('courses','batchs','trainees','requiredCourse','requiredBatch','subjects', 'subjectCount'));

    }

    
    public function markTraineeFinalResultStore(Request $request){

        $course = request('course');
        $batch = request('batch');
        $status = request('status');
        $test = 0;

        $trainees = Trainee::where([['course_id', '=', $course], ['batch_id', '=', $batch]])->get();

        if (!empty($trainees)) {

            foreach ($trainees as $trainee) {

                $Traineestatus = PreAssesmentRsult::traineeFirsttimeEligibility($trainee->id);

                if ($Traineestatus == 1) {

                    $prvresult = PreAssesmentRsult::where([['trainee_id', '=' ,$trainee->id], ['course_id', '=', $course],['batch_id', '=', $batch]])->orderBy('created_at','desc')->first();

                    if (!empty($status)) {

                        if (empty($prvresult)) {
                            $examresult = new PreAssesmentRsult;
                            $examresult->trainee_id  = $trainee->id;
                            $examresult->course_id  = $course;
                            $examresult->batch_id  = $batch;
        
                            if (in_array($trainee->id, $status)) {
                                $examresult->status  = 1;
                            }else {
                                $examresult->status  = 0;
                            }
                            
                            $examresult->save();                   
                        }else {

                            if (in_array($trainee->id, $status)) {
                                $prvresult->status  = 1;                              
                            }else {
                                $prvresult->status  = 0;
                            }
                            $prvresult->save();
                        }
                    }else {

                        if (empty($prvresult)) {

                            $examresult = new PreAssesmentRsult;
                            $examresult->trainee_id  = $trainee->id;
                            $examresult->course_id  = $course;
                            $examresult->batch_id  = $batch;
                            $examresult->status  = 0;
                            $examresult->save();

                        }else {

                            $prvresult->status  = 0;
                            $prvresult->save();
                        }
                    }
                }
            }
        }

        return $this->traineeFinalList();
        
    }


    public function checkFinalResult(){

        $courses = Course::get();
        $batchs  = Batch::get();

        return view('preeassesment.result', compact('courses','batchs'));

    }

    public function finalResult(){

        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');

        $pass = PreAssesmentRsult::calculatePassPrecentage($requiredCourse, $requiredBatch);
        $fail = PreAssesmentRsult::calculateFailPrecentage($requiredCourse, $requiredBatch);

        $subjects = Subject::where('course_id', '=' ,$requiredCourse)->get();

        $traineeResult = PreAssesmentRsult::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch]])->pluck('trainee_id');
        $trainees = Trainee::whereIn('id', $traineeResult)->get();
        return view('preeassesment.result', compact('courses','batchs','trainees','requiredCourse','requiredBatch','subjects','pass','fail'));
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
     * @param  \App\PreAssesmentRsult  $preAssesmentRsult
     * @return \Illuminate\Http\Response
     */
    public function show(PreAssesmentRsult $preAssesmentRsult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreAssesmentRsult  $preAssesmentRsult
     * @return \Illuminate\Http\Response
     */
    public function edit(PreAssesmentRsult $preAssesmentRsult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreAssesmentRsult  $preAssesmentRsult
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PreAssesmentRsult $preAssesmentRsult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreAssesmentRsult  $preAssesmentRsult
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreAssesmentRsult $preAssesmentRsult)
    {
        //
    }
}
