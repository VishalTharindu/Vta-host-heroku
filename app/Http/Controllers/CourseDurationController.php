<?php

namespace App\Http\Controllers;

use App\CourseDuration;
use App\Batch;
use App\Course;
use Illuminate\Http\Request;

class CourseDurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courseDurations = CourseDuration::orderBy('updated_at', 'desc')->get();
        return view('courseduration.index', compact('courseDurations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::orderBy('course_name', 'asc')->select('id', 'course_name')->get();
        $batches = Batch::get();
        return view('courseduration.create', compact('courses', 'batches', 'courses'));
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
            'course_id' => 'required',
            'batch_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        
        $courseDuration = new CourseDuration;
        $courseDuration->course_id = request('course_id');
        $courseDuration->batch_id = request('batch_id');
        $courseDuration->start_date = request('start_date');
        $courseDuration->end_date = request('end_date');
        $courseDuration->save();

        return redirect()->route('courseduration.index')->withStatus(__('Course duration successfully added.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseDuration  $courseDuration
     * @return \Illuminate\Http\Response
     */
    public function show(CourseDuration $courseDuration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseDuration  $courseDuration
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseDuration $courseduration)
    {
        $courses = Course::orderBy('course_name', 'asc')->select('id', 'course_name')->get();
        $batches = Batch::get();
        return view('courseduration.edit', compact('courseduration', 'batches', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseDuration  $courseDuration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseDuration $courseduration)
    {
        $request->validate([
            'course_id' => 'required',
            'batch_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        
        $courseduration->course_id = request('course_id');
        $courseduration->batch_id = request('batch_id');
        $courseduration->start_date = request('start_date');
        $courseduration->end_date = request('end_date');
        $courseduration->update();

        return redirect()->route('courseduration.index')->withStatus(__('Course duration successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseDuration  $courseDuration
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseDuration $courseduration)
    {
        $courseduration->delete();
        return redirect()->route('courseduration.index')->withStatus(__('Course duration successfully deleted.'));
    }
}
