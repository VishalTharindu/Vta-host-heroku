<?php

namespace App\Http\Controllers;

use App\ExaminationPayment;
use App\Trainee;
use App\Batch;
use App\Course;
use App\Examination;
use Illuminate\Http\Request;

class ExaminationPaymentController extends Controller
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

        return view('examination.addpayment', compact('courses','batchs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $courses = Course::get();
        $batchs  = Batch::get();
        $requiredCourse = request('course');
        $requiredBatch = request('batch');

        $trainees = Trainee::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch],['status', '!=', 2]])->get();
        // s
        return view('examination.addpayment', compact('courses','batchs','trainees','requiredCourse','requiredBatch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = request('course');
        $batch = request('batch');
        $status = request('status');
        $test = 0;

        $trainees = Trainee::where([['course_id', '=', $course], ['batch_id', '=', $batch], ['status', '!=', 2]])->get();
        

        if (!empty($trainees)) {
            
            foreach ($trainees as $trainee) {

                $Traineestatus = Examination::traineeCurrentStatus($trainee->id);
                
                if ($Traineestatus == 0) {

                    $prvrecord = ExaminationPayment::where([['trainee_id', '=' ,$trainee->id], ['course_id', '=', $course],['batch_id', '=', $batch]])->orderBy('created_at','desc')->first();
                    if (!empty($status)) {

                        if (empty($prvrecord)) {
                            $paymentrec = new ExaminationPayment;
                            $paymentrec->trainee_id  = $trainee->id;
                            $paymentrec->course_id  = $course;
                            $paymentrec->batch_id  = $batch;
        
                            if (in_array($trainee->id, $status)) {
                                $paymentrec->payment_status  = 1;
                            }else {
                                $paymentrec->payment_status  = 0;
                            }

                            $paymentrec->save();                   
                        }else {

                            if ($prvrecord->payment_status  == 0) {

                                if (in_array($trainee->id, $status)) {
                                    $prvrecord->payment_status  = 1;                              
                                }else {
                                    $prvrecord->payment_status  = 0;
                                }
                                
                                $prvrecord->save();
                            }

                        }
                    }else {

                        if (empty($paymentrec)) {

                            $paymentrec = new ExaminationPayment;
                            $paymentrec->trainee_id  = $trainee->id;
                            $paymentrec->course_id  = $course;
                            $paymentrec->batch_id  = $batch;
                            $paymentrec->status  = 0;
                            $paymentrec->save();

                        }else {
                            if ($prvrecord->payment_status  == 0) {

                                $prvrecord->payment_status  = 0;
                                $prvrecord->save();

                            }
                        }
                    }
                }
            }
        }

        return redirect()->action('ExaminationPaymentController@index')->withStatus(__('Student Exmination Payment success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExaminationPayment  $examinationPayment
     * @return \Illuminate\Http\Response
     */
    public function show(ExaminationPayment $examinationPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExaminationPayment  $examinationPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(ExaminationPayment $examinationPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExaminationPayment  $examinationPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExaminationPayment $examinationPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExaminationPayment  $examinationPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExaminationPayment $examinationPayment)
    {
        //
    }
}
