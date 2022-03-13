<?php

namespace App\Http\Controllers;
use App\Attendance;
use App\Course;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('welcome');
    }

    public function home()
    {
        $courses = Course::orderBy('id', 'asc')->pluck('course_name')->toArray();
        $courseIds = Course::orderBy('id', 'asc')->select('id')->get();
        $counts = array_fill(0, count($courses), 0);
       
        foreach($courseIds as $key=>$courseId){  
                $counts[$key] = Attendance::returnTodayTotalAttendanceCount($courseId->id);
        }
        return view('dashboard', compact('courses', 'counts'));
    }

    public function markNotification()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->noContent();
    }

    public function markSingleNotification($id)
    {
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        return redirect()->back();
    }
}
