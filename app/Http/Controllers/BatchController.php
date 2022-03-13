<?php

namespace App\Http\Controllers;

use App\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Batch $model)
    {
        return view('batch.index', ['batches' => $model->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('batch.create');
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
            'year' => 'required|numeric|min:4',
            'batch' => 'required|numeric',
        ]);

        $checkExistingBatch = Batch::where('year', '=', request('year'))->where('batch_no', '=', request('batch'))->count();
        if ($checkExistingBatch == 0) {
            $batch = new Batch;
            $batch->year = request('year');
            $batch->batch_no = request('batch');
            $batch->save();

            return redirect()->route('batch.index')->withStatus(__('Batch successfully created.'));
        } else {
            return redirect()->route('batch.index')->with('error', __('Batch already exists.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        return view('batch.edit', compact('batch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'year' => 'required|numeric|min:4',
            'batch' => 'required|numeric',
        ]);

        $batch->year = request('year');
        $batch->batch_no = request('batch');
        $batch->update();

        return redirect()->route('batch.index')->withStatus(__('Batch successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->route('batch.index')->withStatus(__('Batch successfully deleted.'));
    }
}
