<?php

namespace App\Http\Controllers;

use App\TrainingInstitute;
use App\Http\Requests\TrainingInstituteRequest;
use Illuminate\Http\Request;

class TrainingInstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TrainingInstitute $trainingInstitute)
    {
        $trainingInstitutes = $trainingInstitute->get();
        return view('trainingInstitute.index', compact('trainingInstitutes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('trainingInstitute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TrainingInstituteRequest $request)
    {
        $validated = $request->validated();

        $trainingInstitute = new TrainingInstitute;

        $trainingInstitute->name = $request->name;
        $trainingInstitute->address = $request->address;
        $trainingInstitute->phone_no = $request->phone_no;
        $trainingInstitute->save();
        return redirect()->route('trainingInstitute.index')->withStatus(__('New Training Institute Added Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingInstitute $trainingInstitute)
    {
        return view('trainingInstitute.edit', compact('trainingInstitute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TrainingInstituteRequest $request, TrainingInstitute $trainingInstitute)
    {
        $validated = $request->validated();

        $trainingInstitute->name = $request->name;
        $trainingInstitute->address = $request->address;
        $trainingInstitute->phone_no = $request->phone_no;
        $trainingInstitute->update();

        return redirect()->route('trainingInstitute.index')->withStatus(__('Training Institute Data Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingInstitute $trainingInstitute)
    {
        if($trainingInstitute->trainees->count() > 0){
            return redirect()->route('trainingInstitute.index')->withError(__('You cannot delete this. Because this company is used in Trainees'));
        }
        return redirect()->route('trainingInstitute.index')->withStatus(__('Training Institute Data Deleted Successfully'));
    }
}
