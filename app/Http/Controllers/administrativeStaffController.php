<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use jeremykenedy\LaravelRoles\Models\Role as Role;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class administrativeStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $users)
    {
    
        $users = User::where([
            ['id', '!=', auth()->id()],
            ['user_type', '!=', 'Instructor'],
            ['user_type', '!=', 'Demonstrator'],
        ])->get();
        
        return view('adminStaff.index ', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('adminStaff.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'role_id' => 'required'
        ]);
        $role = config('roles.models.role')::where('id', '=', request('role_id'))->first(); //choose the default role upon user creation.
        
        
        $user = config('roles.models.defaultUser')::create([
            'name' => request('name'),
            'email' => request('email'),
            'user_type' => $role->name,
            'password' => Hash::make(request('password')),
        ]);

        $user->attachRole($role);

        return redirect()->route('adminStaff.index')->withStatus(__('Adminstrative Staff successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $adminStaff)
    {
        //$adminStaff = User::where('id',$id)->first();
        $roles = Role::get();
        return view('adminStaff.edit', compact('adminStaff','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $adminStaff)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
            'role_id' => 'required'
        ]);
        $role = config('roles.models.role')::where('id', '=', request('role_id'))->first();
        
        $adminStaff->name = request('name');
        $adminStaff->email = request('email');
        $adminStaff->user_type = $role->name;
        $adminStaff->save();

        $adminStaff->syncRoles($role);
        return redirect()->route('adminStaff.index')->withStatus(__('Adminstrative Staff successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $adminStaff)
    {
        $adminStaff->delete();
        return redirect()->route('adminStaff.index')->withStatus(__('Administrative Staff successfully deleted.'));
    }
}
