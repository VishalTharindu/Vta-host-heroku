<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Dropout;
use App\Trainee;
use App\Batch;
use App\Course;
use App\CourseDuration;
use DB;
use LPDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DropoutController extends Controller
{

    /*
    ******************************************************************************************************************
        Status = 2 in Trainee Table
            - The trainee has been suspened from the course due to 30days absence
    ******************************************************************************************************************
    */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dropoutList = Dropout::whereBetween('no_of_absents', [14, 29])->get();
        return view('dropout.index', compact('dropoutList'));
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
        //
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
    public function edit(Dropout $dropout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dropout $dropout)
    {
        $dropout->delete();
        return redirect()->route('dropout.index')->withStatus(__('Dropout successfully deleted.'));
    }


    //Suspended Routes
    public function suspendedIndex()
    {
        $trainees = Trainee::where([['status',2]])->get();
        $courses = Course::get();
        $batches = Batch::get();
        $maleCount = $trainees->where('gender', 'male')->count();
        $femaleCount = $trainees->where('gender', 'female')->count();
      
        return view('dropout.suspened', compact('trainees', 'courses', 'batches', 'maleCount', 'femaleCount'));
    }

    public function filterData(Trainee $trainee)
    {
        $filterCourse  = request('filterCourse');
        $filterBatch = request('filterBatch');

        $courses = Course::get();
        $batches = Batch::get();

        if ($filterBatch != 0 && $filterCourse != 0) {
            $trainees = $trainee->where([['status', 2],['course_id',$filterCourse],['batch_id', $filterBatch]]);
            $maleCount = $trainees->where('gender', 'male')->count();
            $femaleCount = $trainees->where('gender', 'female')->count();
            
            return view('dropout.suspened', compact('trainees', 'courses', 'batches', 'filterCourse', 'filterBatch', 'maleCount', 'femaleCount'));
        } elseif ($filterBatch == 0 && $filterCourse == 0) {
            //redirect to index
            return redirect()->route('suspended.index');
        } elseif ($filterBatch != 0 && $filterCourse == 0) {
            $trainees = $trainee->where([['status', 2],['batch_id', $filterBatch]]);
            $maleCount = $trainees->where('gender', 'male')->count();
            $femaleCount = $trainees->where('gender', 'female')->count();

            return view('dropout.suspened', compact('trainees', 'courses', 'batches', 'filterBatch', 'maleCount', 'femaleCount'));
        } elseif ($filterBatch == 0 && $filterCourse != 0) {
            $trainees = $trainee->where([['status', 2],['course_id',$filterCourse]]);
            $maleCount = $trainees->where('gender', 'male')->count();
            $femaleCount = $trainees->where('gender', 'female')->count();

            return view('dropout.suspened', compact('trainees', 'courses', 'batches', 'filterCourse', 'maleCount', 'femaleCount'));
        }
    }

    public function suspendReconsider(Trainee $trainee)
    {
        return view('dropout.reconsider', compact('trainee'));
    }

    public function uploadMedicalReports(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'medical_report' => 'required|mimes:jpeg,bmp,png,gif,svg,pdf',
            'other_report' => 'mimes:jpeg,bmp,png,gif,svg,pdf',
        ]);

        $medical_report= request('enrollment_no') . '_' . uniqid('') . '.' . $request->medical_report->getClientOriginalExtension();
        $request->medical_report->storeAs('medical_reports', $medical_report); //store the file
        
        if ($request->hasFile('other_report')) {
            $other_report= request('enrollment_no') . '_' . uniqid('') . '.' . $request->other_report->getClientOriginalExtension();
            $request->other_report->storeAs('medical_reports_other', $other_report); //store the file
        } else {
            $other_report = "NULL";
        }
        
    
        //adding the medical_reports
        DB::table('medical_reports')->insert(
            [
            'trainee_id' => request('id'),
            'medical_report' => $medical_report,
            'other_report' => $other_report,
            'created_at' => Carbon::now()->toDateString(),
            'updated_at' => Carbon::now()]
        );

        $trainee = Trainee::find(request('id'));
        $trainee->status = 0;
        $trainee->update();

        return redirect()->route('suspended.index')->withStatus(__('Trainee successfully restored.'));
    }

    public function suspendReconsiderIndex()
    {
        $restoreRecords =  DB::table('medical_reports')->get();

        return view('dropout.restored', compact('restoreRecords'));
    }

    public function generateWarningPdf(Trainee $trainee)
    {
        $traineeCourseDuration = CourseDuration::where([['course_id', $trainee->course->id],['batch_id', $trainee->batch->id]])->first();
        $noOfAbsents = Dropout::where('trainee_id',$trainee->id)->pluck('no_of_absents')->first();


        $totalCourseConductedDays = Attendance::returnTotalAttendanceMarkedDays($trainee->id); 

        $data = [
            'name' => $trainee->full_name,
            'course' => $trainee->course->course_name,
            'no_of_absent_days' => $noOfAbsents,
            'total_days' => $totalCourseConductedDays,
            'precentage_of_absence' => round(($noOfAbsents/$totalCourseConductedDays) * 100,2),
        ];
        $fileName = $trainee->full_name . '-Warning Letter.pdf';
        $pdf = LPDF::loadView('dropout.pdf.warning_letter', $data);

        $dropoutRecord = Dropout::where('trainee_id', $trainee->id)->first();
        $dropoutRecord->letter_issued = 1;
        $dropoutRecord->update();

        return $pdf->download($fileName);
    }

    public function generateSuspendPdf(Trainee $trainee)
    {
        $traineeCourseDuration = CourseDuration::where([['course_id', $trainee->course->id],['batch_id', $trainee->batch->id]])->first();
        
        $data = [
            'name' => $trainee->full_name,
            'MIS' => $trainee->enrollment_no,
            'course' => $trainee->course->course_name,
            'course_duration' => $trainee->course->course_duration,
            'course_start' => $traineeCourseDuration->start_date,
            'course_end' => $traineeCourseDuration->end_date,
            'course_fee' => $trainee->course->course_fee,
        ];
        $fileName = $trainee->enrollment_no . '-Leave Letter.pdf';
        $pdf = LPDF::loadView('dropout.pdf.dropout_letter', $data);

        $dropoutRecord = Dropout::where('trainee_id', $trainee->id)->first();
        $dropoutRecord->suspend_letter = 1;
        $dropoutRecord->update();

        return $pdf->download($fileName);
    }

    public function suspendedCountByCourse()
    {
        $trainees =  Trainee::where('status', 2)->select('course_id')->get();
        $counts = $trainees->countBy('course_id');

        $courses = Course::select('id', 'course_name')->get();

        foreach ($courses as $course) {
            foreach ($counts as $key=>$count) {
                if ($key == $course->id) {
                    $course->count = $count;
                }
            }
        }
        return view('dropout.suspendedcount', compact('courses'));
    }

    public function uploadLeaveLetter(Request $request)
    {
        if ($request->hasFile('letter')) {
            $letter= request('trainee_id') . '_leave_letter' . uniqid('') . '.' . $request->letter->getClientOriginalExtension();
            $request->letter->storeAs('leave_letters', $letter);
        } else {
            $letter = "";
        }

        $dropoutRecord = Dropout::where('trainee_id', request('trainee_id'))->first();
        $dropoutRecord->suspend_letter_file = $letter;
        $dropoutRecord->suspend_letter = 2;
        $dropoutRecord->update();

        return redirect()->route('suspended.index')->withStatus(__('File successfully uploaded.'));
    }
}
