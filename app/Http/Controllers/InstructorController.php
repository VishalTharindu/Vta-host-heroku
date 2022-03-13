<?php

namespace App\Http\Controllers;

use App\Instructor;
use App\Course;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\InstructorRequest;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Instructor $model)
    {
        return view('instructor.index ', ['instructors' => $model->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::select('id', 'course_name')->get();
        return view('instructor.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstructorRequest $request)
    {
        $validated = $request->validated();
        
        $user = config('roles.models.defaultUser')::create([
            'name' => request('first_name'),
            'email' => request('login-email'),
            'user_type' => 'Instructor',
            'password' => Hash::make(request('login-password')),
        ]);

        $role = config('roles.models.role')::where('name', '=', 'Instructor')->first();  //choose the default role upon user creation.
        $user->attachRole($role);
        
        $instructor = new Instructor;
        $instructor->user()->associate($user);
        $instructor->course_id = request('course_id');
        $instructor->first_name = request('first_name');
        $instructor->last_name = request('last_name');
        $instructor->nic = request('nic');
        $instructor->email = request('email');
        $instructor->phone_number = request('phone_number');
        $instructor->address = request('address');
        $instructor->city = request('city');
        $instructor->save();

        return redirect()->route('instructor.index')->withStatus(__('Instructor successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function show(Instructor $instructor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function edit(Instructor $instructor)
    {
        $courses = Course::select('id', 'course_name')->get();
        return view('instructor.edit', compact('instructor', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function update(InstructorRequest $request, Instructor $instructor)
    {
        $validated = $request->validated();
        $instructor->course_id = request('course_id');
        $instructor->first_name = request('first_name');
        $instructor->last_name = request('last_name');
        $instructor->nic = request('nic');
        $instructor->email = request('email');
        $instructor->phone_number = request('phone_number');
        $instructor->address = request('address');
        $instructor->city = request('city');
        $instructor->save();

        return redirect()->route('instructor.index')->withStatus(__('Instructor successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instructor $instructor)
    {
        $instructor->delete();
        return redirect()->route('instructor.index')->withStatus(__('Instructor successfully deleted.'));
    }
}
