<?php

namespace App\Http\Controllers;

use App\Subject;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::orderBy('course_id', 'asc')->get();
        return view('subject.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::orderBy('course_name', 'asc')->select('id', 'course_name')->get();
        return view('subject.create', compact('courses'));
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
        ]);
        
        $courseId = request('course_id');
        $subjectNames = request('subject_name');
        $subjectCodes = request('subject_code');

        if ($courseId == "NULL" || $subjectNames[0] == null || $subjectCodes[0] == null) {
            return redirect()->route('subject.create')->withError(__('Please try again! Check your inputs'));
        }

        foreach ($subjectNames as $key=>$subjectName) {
            $subject = new Subject;
            $subject->course_id = $courseId;
            $subject->subject_name = $subjectName;
            $subject->subject_code = $subjectCodes[$key];
            $subject->save();
        }

        return redirect()->route('subject.index')->withStatus(__('Subjects successfully added.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $courses = Course::orderBy('course_name', 'asc')->select('id', 'course_name')->get();
        return view('subject.edit', compact('courses', 'subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $courseId = request('course_id');
        $subjectName = request('subject_name');
        $subjectCode = request('subject_code');

        if ($courseId == "NULL" || $subjectName[0] == null || $subjectCode[0] == null) {
            return redirect()->route('subject.create')->withError(__('Please try again! Check your inputs'));
        }
        
        $subject->course_id = $courseId;
        $subject->subject_name = $subjectName[0];
        $subject->subject_code = $subjectCode[0];
        $subject->update();

        return redirect()->route('subject.index')->withStatus(__('Subject successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subject.index')->withStatus(__('Subject successfully deleted.'));
    }
}
