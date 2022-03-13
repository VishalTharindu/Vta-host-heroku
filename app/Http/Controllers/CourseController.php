<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Course $model)
    {
        return view('course.index', ['courses' => $model->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course.create');
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
            'course_name' => 'required|string|min:4',
            'course_duration' => 'required|numeric',
            'nvq_level' => 'required|numeric',
            'registration_fee' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'course_fee' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $course = new Course;
        $course->course_name = request('course_name');
        $course->course_duration = request('course_duration');
        $course->nvq_level = request('nvq_level');
        $course->registration_fee = request('registration_fee');
        $course->course_fee = request('course_fee');
        $course->save();

        return redirect()->route('course.index')->withStatus(__('Course successfully created.'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_name' => 'required|string|min:4',
            'course_duration' => 'required|numeric',
            'nvq_level' => 'required|numeric',
            'registration_fee' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'course_fee' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $course->course_name = request('course_name');
        $course->course_duration = request('course_duration');
        $course->nvq_level = request('nvq_level');
        $course->registration_fee = request('registration_fee');
        $course->course_fee = request('course_fee');
        $course->save();

        return redirect()->route('course.index')->withStatus(__('Course successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('course.index')->withStatus(__('Course successfully deleted.'));
    }
}
