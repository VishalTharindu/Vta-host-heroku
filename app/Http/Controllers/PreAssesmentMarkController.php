<?php

namespace App\Http\Controllers;

use App\PreAssesmentMark;
use App\PreAssesmentRsult;
use App\Trainee;
use App\Batch;
use App\Course;
use App\Subject;
use App\Attendance;
use Illuminate\Http\Request;

class PreAssesmentMarkController extends Controller
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
     * @param  \App\PreAssesmentMark  $preAssesmentMark
     * @return \Illuminate\Http\Response
     */
    public function show(PreAssesmentMark $preAssesmentMark)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreAssesmentMark  $preAssesmentMark
     * @return \Illuminate\Http\Response
     */
    public function edit(PreAssesmentMark $preAssesmentMark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreAssesmentMark  $preAssesmentMark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PreAssesmentMark $preAssesmentMark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreAssesmentMark  $preAssesmentMark
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreAssesmentMark $preAssesmentMark)
    {
        //
    }
    public function markSubjectResult(Request $request)
    {

        $course = request('course');
        $batch = request('batch');
        $subject = request('subject');

        $trainees = Trainee::where([['course_id', '=', $course], ['batch_id', '=', $batch]])->get();

        foreach ($trainees as $value) {
            $status = PreAssesmentRsult::traineeFirsttimeEligibility($value->id);
            $precentage = Attendance::calculateAttendanceEligibility($value->id);

            if (($status == 1) && ($precentage >= 80)) {

                $currentMarks = PreAssesmentMark::where([['trainee_id', '=' ,$value->id], ['subject_id', '=', $subject]])->orderBy('created_at','desc')->first();

                $mark = $request->rows[$value->id]['marks'];

                if (empty($currentMarks)) {               
                    $subjectMark = new PreAssesmentMark();
                    $subjectMark ->trainee_id = $value->id;
                    $subjectMark ->subject_id = $subject;          
                    if(empty($mark)){
                        $subjectMark ->preasses_marks = "A/B";
                    }else {
                        $subjectMark ->preasses_marks = $mark;
                    }
                    $subjectMark->save();              
                }else{
                    $currentMarks->preasses_marks = $mark;
                    $currentMarks->save();
                }
            }
        }

        return app('App\Http\Controllers\PreAssesmentRsultController')->markSubjectView()->withStatus(__('subject has been marked successfully'));;

    }
}
