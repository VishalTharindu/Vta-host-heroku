<?php

namespace App\Http\Controllers;

use App\Mark;
use App\Trainee;
use App\Examination;
use App\Attendance;
use App\Batch;
use App\Course;
use App\Subject;
use App\ExaminationPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function show(Mark $mark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function edit(Mark $mark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mark $mark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mark $mark)
    {
        //
    }

    public function markSubjectResult(Request $request)
    {        
        $course = request('course');
        $batch = request('batch');
        $subject = request('subject');
        $type = request('type');

        $trainees = Trainee::where([['course_id', '=', $course], ['batch_id', '=', $batch], ['ojt_letter_issued', '!=', 0]])->get();

        foreach ($trainees as $value) {
            $status = Examination::traineePassFailStatus($value->id);
            $precentage = Attendance::calculateAttendanceEligibility($value->id);
            $paiedtrainees = ExaminationPayment::paiedTrainess($value->id);
            if (($precentage >= 80) && ($paiedtrainees == 1) && ($status == 1)) {

                // $currentMarks = Mark::where([['trainee_id', '=' ,$value->id], ['subject_id', '=', $subject]])->orderBy('created_at','desc')->first();

                $Wmark = $request->rows[$value->id]['Wmarks'];
                $Pmark = $request->rows[$value->id]['Pmarks'];
                $attempt = $request->rows[$value->id]['attempt'];

                if ($Wmark > 60) {
                    return redirect()->action('ExaminationController@markSubjectView')->withError(__('Written Exam Result Connot Exceed level of 60%'));
                }elseif ($Pmark > 40) {
                    return back()->action('ExaminationController@markSubjectView')->withError(__('Practicle Exam Result Connot Exceed level of 40%'));
                }


                if (!empty($Wmark && $Pmark)) {               
                    $subjectMark = new Mark();
                    $subjectMark ->trainee_id = $value->id;
                    $subjectMark ->subject_id = $subject;         
                    $subjectMark ->attempt = $attempt;
                    $subjectMark ->course_id = $course;
                    $subjectMark ->batch_id = $batch;
                    $subjectMark ->Wmarks = $Wmark;
                    $subjectMark ->Pmarks = $Pmark;
                    $subjectMark->save();              
                }else{
                    $subjectMark ->Wmarks = "A/B";
                    $subjectMark ->Pmarks = "A/B";
                    $currentMarks->save();
                }
            }
        }

        // return app('App\Http\Controllers\ExaminationController')->markSubjectView()->withStatus(__('subject has been marked successfully'));
        return redirect()->action('ExaminationController@markSubjectView')->withStatus(__('subject has been marked successfully'));

    }

    public function selectSubjectView()
    {
        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.subjectwiceresult', compact('courses','batchs'));
        
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

    public function subjectResult(Request $request){

        $courses = Course::get();
        $batchs  = Batch::get();

        $requiredCourse = request('course');
        $requiredBatch = request('batch');
        $subject = request('subjects');

        $requiredSubject = Subject::where('id', '=' ,$subject)->get();

        $trainees = Trainee::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['ojt_letter_issued', '!=', 0]])->get();
        return view('examination.subjectwiceresult', compact('courses','batchs','trainees','requiredCourse','requiredBatch','requiredSubject','subject'));

        
    }

    public function markSubjectPracticalView()
    {
        $courses = Course::get();
        $batchs  = Batch::get();

        return view('examination.marksubjectpractical', compact('courses','batchs'));
        
    }

    public function subjectPracticalTrainee(Request $request)
    {
        
        $courses = Course::get();
        $batchs  = Batch::get();

        $requiredCourse = request('course');
        $requiredBatch = request('batch');
        $subject = request('subjects');

        $requiredSubject = Subject::where('id', '=' ,$subject)->get();

        $traineeResult = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['status', '=', 1]])->orderBy('created_at','desc')->pluck('trainee_id');
        $trainees = Trainee::whereIn('id', $traineeResult)->get();

        return view('examination.marksubjectpractical', compact('courses','batchs','trainees','requiredCourse','requiredBatch','requiredSubject','subject'));

        
    }

    public function markPracticalResult(Request $request)
    {

        $course = request('course');
        $batch = request('batch');
        $subject = request('subject');
        $type = request('type');

        $traineeResult = Examination::where([['course_id', '=', $course], ['batch_id', '=', $batch], ['status', '=', 1]])->orderBy('created_at','desc')->pluck('trainee_id');
        $trainees = Trainee::whereIn('id', $traineeResult)->get();

        foreach ($trainees as $value) {
            $status = Examination::traineePracticlStatus($value->id);
            if($status == 0){
                $currentMarks = Mark::where([['trainee_id', '=' ,$value->id], ['subject_id', '=', $subject], ['type', '=', 'P']])->orderBy('created_at','desc')->first();
    
                $mark = $request->rows[$value->id]['marks'];
    
                if (empty($currentMarks)) {               
                    $subjectMark = new Mark();
                    $subjectMark ->trainee_id = $value->id;
                    $subjectMark ->subject_id = $subject;
                    $subjectMark ->type = $type;           
                    if(empty($mark)){
                        $subjectMark ->marks = "A/B";
                    }else {
                        $subjectMark ->marks = $mark;
                    }
                    $subjectMark->save();              
                }else{
                    $currentMarks->marks = $mark;
                    $currentMarks->save();
                }
            }
        }

        return redirect()->action('MarkController@markSubjectPracticalView')->withStatus(__('subject has been marked successfully'));
        // return redirect()->action('ExaminationController@markSubjectView')->markSubjectView()->withStatus(__('subject has been marked successfully'));

    }
}
