<?php

namespace App\Http\Controllers;

use App\PreAssesment;
use App\Batch;
use App\Course;
use Illuminate\Http\Request;

class PreAssesmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PreAssesment $model)
    {
        // $preAssesment = PreAssesment::get();
        return view('preeassesment.predate.index', ['preassesment' => $model->get()]);
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

        return view('preeassesment.predate.create', compact('courses','batchs'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'asses_date' => 'required',           
        ]);
        
        $date = request('asses_date');
        $requiredCourse = request('course');
        $requiredBatch = request('batch');
    
        $preass = PreAssesment::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['date', '=', $date],['status', '!=', 1]])->get();

        if (count($preass) > 0) {
            return redirect()->back()->withError(__('This pre assesment date is alrady fixed'));
        }

        $preasses = new PreAssesment();
        $preasses->course_id  = $requiredCourse;
        $preasses->batch_id = $requiredBatch;
        $preasses->date = $date;
        $preasses->save();

        return redirect()->route('preassesment.index')->withStatus(__('Pre Assesment Date Successfully Added.'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PreAssesment  $preAssesment
     * @return \Illuminate\Http\Response
     */
    public function show(PreAssesment $preAssesment)
    {
        return view('preeassesment.predate.index', 'preAssesment');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreAssesment  $preAssesment
     * @return \Illuminate\Http\Response
     */
    public function edit(PreAssesment $preAssesment)
    {
        $courses = Course::get();
        $batchs  = Batch::get();

        return view('preeassesment.predate.edit', compact('courses','batchs','preAssesment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreAssesment  $preAssesment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PreAssesment $preAssesment)
    {

            $request->validate([
                'asses_date' => 'required',           
            ]);
            
            $preAssesment->course_id  = request('course');
            $preAssesment->batch_id = request('batch');
            $preAssesment->date = request('asses_date');
            $preAssesment->save();

            return redirect()->route('preassesment.index')->withStatus(__('Pre Assesment Successfully updated.'));
    }

    public function assestmentComnplete( PreAssesment $preAssesment ){

        $preAssesment->status = 1;
        $preAssesment->save();

        return redirect()->route('preassesment.index')->withStatus(__('Pre Assesment Successfully Completed.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreAssesment  $preAssesment
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreAssesment $preAssesment)
    {
        $preAssesment->delete();
        return redirect()->route('preassesment.index')->withStatus(__('Pre Assesment Successfully Removed.'));
    }
}
