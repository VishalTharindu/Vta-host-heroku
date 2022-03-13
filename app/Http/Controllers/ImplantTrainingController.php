<?php

namespace App\Http\Controllers;

use DPDF;
use App\Trainee;
use App\Course;
use App\Batch;
use App\TrainingInstitute;
use App\CourseDuration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ImplantTrainingController extends Controller
{

/* 
******************************************************************************************************************
    When ojt_letter_issued = 1 in Trainee Table
        - Which means that that the OJT letter has being printed to send to the company

    When Status = 3 in Trainee Table
        - This to select the trainees of a particuar course in a pariticular batch to enter the Implant Training data
******************************************************************************************************************    
*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Trainee $trainee)
    {
        $trainees = Trainee::where([
            ['status', '!=', 2],
        ])->get();
        
        $courses = Course::get();
        $batches = Batch::get();
        
        return view('implantTraining.letter', compact('trainees','courses','batches'));
    }

    /**
     * Filter trainee data in implant training in the Letter sending blade
     *
     * @return \Illuminate\Http\Response
     */
    public function filterData(Trainee $trainee)
    {

        $filterCourse  = request('filterCourse');
        $filterBatch = request('filterBatch');

        $courses = Course::get();
        $batches = Batch::get();

        if($filterBatch != 0 && $filterCourse != 0){

            $cName = Course::select('course_name')->where('id',$filterCourse)->first();
            $bName = Batch::select('year','batch_no')->where('id',$filterBatch)->first();
            $trainees = $trainee->filter($filterBatch,$filterCourse);
            $letterNeeded = $trainees->where('ojt_letter_issued',0)->count();

            return view('implantTraining.letter', compact('trainees','courses','batches','filterCourse','filterBatch','cName','bName','letterNeeded'));

        }
        elseif($filterBatch == 0 && $filterCourse == 0){

            return redirect()->route('implantTraining.letter');

        }
        elseif($filterBatch != 0 && $filterCourse == 0){

            $trainees = $trainee->filterBatch($filterBatch);
            return view('implantTraining.letter', compact('trainees','courses','batches','filterBatch'));

        }
        elseif($filterBatch == 0 && $filterCourse != 0){

            $trainees = $trainee->filterCourse($filterCourse);
            return view('implantTraining.letter', compact('trainees','courses','batches','filterCourse'));

        }


    }

    /**
     * Generate the PDF
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePdf(Trainee $trainee, Request $request){

        $validatedData = $request->validate([

            'receiver_name' => 'required',
            'company_address' => 'required',

        ]);
        
        //get the course duration to get the start and end date
        $getDates = CourseDuration::where([
            ['batch_id', '=', $trainee->batch->id],
            ['course_id', '=', $trainee->course->id],
        ])->first();

        if(!$getDates){
            return redirect()->route('implantTraining.letter')->withError(__('You have not yet set the course duration for the particular Course and Batch'));
        }
        //Get the address as a array by dividing from the comma
        $address = explode(',', $request->company_address);

        $data = [
            'receiver_name' => $request->receiver_name,
            'address' => $address,     
            'course_name' => $trainee->course->course_name,
            'trainee_name' => $trainee->name_with_initials,
            'start_date' => Carbon::parse($getDates->start_date)->isoFormat('Do [of] MMMM YYYY'),
            'end_date' => Carbon::parse($getDates->end_date)->isoFormat('Do [of] MMMM YYYY'),
            ];

        //Status 3 means OJT letter has issued
        Trainee::where('id', $trainee->id)->update([
            'ojt_letter_issued' => 1
            ]);
            
        $pdf = DPDF::loadView('implantTraining.pdf_view', $data);
        return $pdf->download($trainee->name_with_initials.' OJT_Letter.pdf');
            
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ojtForm(Trainee $trainee)
    {
        $courses = Course::get();
        $batches = Batch::get();
        $selected = false;

        if($traineeInstitutes = TrainingInstitute::get()->count() == 0){
            return redirect()->route('trainingInstitute.index')->withError(__('Before adding Training Data add the companies details here'));
        }

        if($trainee->where('status',3)->count() > 0){
            
            $selected = true;
            $trainees = $trainee->where('status',3)->get();
            $traineeInstitutes = TrainingInstitute::get();

            return view('implantTraining.ojtForm', compact('trainees','courses','batches','selected','traineeInstitutes'));
        }

        $trainees = Trainee::where([
            ['status', '!=', 2],
        ])->get();
        
        return view('implantTraining.ojtForm', compact('trainees','courses','batches','selected'));
    }

    /**
     * Filter out the trainees accoring to batch and course
     *
     * @return \Illuminate\Http\Response
     */
    public function filterBatchAndCourse(Request $request, Trainee $trainee)
    {
        
        $validatedData = $request->validate([

            'course_id' => 'required',
            'batch_id' => 'required',

        ]);

        $filterCourse  = request('course_id');
        $filterBatch = request('batch_id');

        $courses = Course::get();
        $batches = Batch::get();
        $traineeInstitutes = TrainingInstitute::get();
        $trainees = $trainee->filter($filterBatch,$filterCourse);

        if($trainees->count() == 0){
            return redirect()->route('implantTraining.ojtForm')->withError(__('No trainees are available'));
        }
        
        foreach($trainees as $trainee){
            Trainee::where('id', $trainee->id)
            ->update([
                'status' => 3,
                ]);
        }
        return redirect()->route('implantTraining.ojtForm');


    }

    /**
     * Filter out the trainees accoring to batch and course
     *
     * @return \Illuminate\Http\Response
     */
    public function change(Trainee $trainee){

        $trainees = $trainee->where('status',3)->get();
        foreach($trainees as $trainee){
            Trainee::where('id', $trainee->id)
            ->update([
                'status' => 0,
                ]);
        }

        return redirect()->route('implantTraining.ojtForm');
    }
    
    /**
     * Filling up the On training details of the trainee
     *
     * @return \Illuminate\Http\Response
     */
    public function trainingDetails(Trainee $trainee, Request $request){
        
        Trainee::where('id', $trainee->id)
            ->update([
                'ojt_start_date' => $request->start_date,
                'ojt_end_date' => $request->end_date,
                'training_institute_id' => $request->traineeInstitute_id,
                ]);
        
        return redirect()->route('implantTraining.ojtForm')->withStatus(__('Trainee Training Data Updated Successfully'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generateForm(Trainee $trainee)
    {
        $trainees = Trainee::where([
            ['status', '=', 3],
            ['training_institute_id', '=', null],
        ])->count();

        //If there are more trainees in this selected part to be updated about the implant training redirect back with an error
        if($trainees > 0){
            return redirect()->route('implantTraining.ojtForm')->withError(__('There are more trainee data to be updated about the implant training'));
        }
        
        $trainees = Trainee::where([
            ['status', '=', 3],
        ])->get();
        $trainee = Trainee::where('status',3)->first();
        
        $data = [
            'trainees' => $trainees,
            'course' => $trainee->course->course_name,
            'year' => $trainee->batch->year,
            'batch_no' => $trainee->batch->batch_no,
            'count' => 0,
            ];

        $pdf = DPDF::loadView('implantTraining.formPDF', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('Training log '.$trainee->course->course_name.'/'.$trainee->batch->year.'-'. $trainee->batch->batch_no.'.pdf');
    }
}