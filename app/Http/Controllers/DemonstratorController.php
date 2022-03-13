<?php

namespace App\Http\Controllers;

use App\Demonstrator;
use App\Course;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\DemonstratorRequest;

class DemonstratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Demonstrator $model)
    {
        return view('demonstrator.index', ['demonstrators' => $model->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::select('id', 'course_name')->get();
        return view('demonstrator.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DemonstratorRequest $request)
    {
        $validated = $request->validated();

        $user = config('roles.models.defaultUser')::create([
            'name' => request('first_name'),
            'email' => request('login-email'),
            'user_type' => 'Demonstrator',
            'password' => Hash::make(request('login-password')),
        ]);

        $role = config('roles.models.role')::where('name', '=', 'Demonstrator')->first();  //choose the default role upon user creation.
        $user->attachRole($role);

        $demonstrator = new Demonstrator;
        $demonstrator->user()->associate($user);
        $demonstrator->nic = request('nic');
        $demonstrator->first_name = request('first_name');
        $demonstrator->last_name = request('last_name');
        $demonstrator->email = request('email');
        $demonstrator->phone_number = request('phone_number');
        $demonstrator->address = request('address');
        $demonstrator->city = request('city');
        $demonstrator->save();

        if ($request->courses) {
            $demonstrator->courses()->attach($request->courses);
        }


        return redirect()->route('demonstrator.index')->withStatus(__('Demonstrator successfully added.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Demonstrator  $demonstrator
     * @return \Illuminate\Http\Response
     */
    public function show(Demonstrator $demonstrator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Demonstrator  $demonstrator
     * @return \Illuminate\Http\Response
     */
    public function edit(Demonstrator $demonstrator)
    {
        $courses = Course::select('id', 'course_name')->get();
        return view('demonstrator.edit', compact('demonstrator', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Demonstrator  $demonstrator
     * @return \Illuminate\Http\Response
     */
    public function update(DemonstratorRequest $request, Demonstrator $demonstrator)
    {
        $validated = $request->validated();
        
        $demonstrator->nic = request('nic');
        $demonstrator->first_name = request('first_name');
        $demonstrator->last_name = request('last_name');
        $demonstrator->email = request('email');
        $demonstrator->phone_number = request('phone_number');
        $demonstrator->address = request('address');
        $demonstrator->city = request('city');
        $demonstrator->save();

        if ($request->courses) {
            $demonstrator->courses()->sync($request->courses);
        }


        return redirect()->route('demonstrator.index')->withStatus(__('Demonstrator successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Demonstrator  $demonstrator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demonstrator $demonstrator)
    {
        $demonstrator->courses()->detach($demonstrator->courses);
        $demonstrator->delete();
        return redirect()->route('demonstrator.index')->withStatus(__('Demonstrator successfully deleted.'));
    }
}
