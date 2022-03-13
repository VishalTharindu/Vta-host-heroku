<?php

namespace App\Http\Controllers;

use App\Certificate;
use App\Trainee;
use App\Batch;
use App\Course;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::get();
        $batches = Batch::get();
        $certificates = Certificate::orderBy('id','desc')->paginate(10);
        
        return view('certificate.index', compact('certificates', 'courses', 'batches'));
    }

    public function filterData(Trainee $trainee)
    {
        $filterCourse  = request('filterCourse');
        $filterBatch = request('filterBatch');

        $courses = Course::get();
        $batches = Batch::get();

        if ($filterBatch != 0 && $filterCourse != 0) {

            $trainees = $trainee->where([['course_id',$filterCourse],['batch_id', $filterBatch]])->pluck('id');
            $certificates = Certificate::orderBy('id','desc')->whereIn('trainee_id', $trainees)->paginate(10);

            return view('certificate.index', compact('certificates', 'courses', 'batches', 'filterCourse', 'filterBatch'));

        } elseif ($filterBatch == 0 && $filterCourse == 0) {

            return redirect()->route('certificate.index');

        } elseif ($filterBatch != 0 && $filterCourse == 0) {

            $trainees = $trainee->where([['batch_id', $filterBatch]])->pluck('id');
            $certificates = Certificate::orderBy('id','desc')->whereIn('trainee_id', $trainees)->paginate(10);

            return view('certificate.index', compact('certificates', 'courses', 'batches', 'filterBatch'));

        } elseif ($filterBatch == 0 && $filterCourse != 0) {
            $trainees = $trainee->where([['course_id',$filterCourse]])->pluck('id');
            $certificates = Certificate::orderBy('id','desc')->whereIn('trainee_id', $trainees)->paginate(10);

            return view('certificate.index', compact('certificates', 'courses', 'batches', 'filterCourse'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'enrolledno' => 'required',
            'issued_date' => 'required',
            'certificate' => 'mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        $certificate_proof = request('enrollment_no') . '_' . uniqid('') . '.' . $request->certificate->getClientOriginalExtension();
        $request->certificate->storeAs('certificates', $certificate_proof); //store the file
        

        $traineeId = Trainee::where('enrollment_no', request('enrolledno'))->pluck('id')->first();

        $certificate = new Certificate;
        $certificate->trainee_id = $traineeId;
        $certificate->certificate_photo = $certificate_proof;
        $certificate->issued_date = request('issued_date');
        $certificate->save();

        return redirect()->route('certificate.index')->withStatus(__('Certificate successfully Issued.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificate $certificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificate $certificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return redirect()->route('certificate.index')->withStatus(__('Certificate successfully deleted.'));
    }
}
