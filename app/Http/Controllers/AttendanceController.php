<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Batch;
use App\Calendar;
use App\Course;
use App\Dropout;
use App\Instructor;
use App\Demonstrator;
use App\Http\Requests\AttendanceRequest;
use App\Trainee;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Calendar::isTodayHoliday()) {
            return redirect()->route('home')->withError(__('Today is a marked as a holiday! You can not mark attendance.'));
        }
        
        $batches = Batch::get();
        $authUser = 'User';
        $authUserModel = Auth::user()->getUserModel();
        if ($authUserModel instanceof Instructor) {
            $courses =  $authUserModel->course;
            $authUser = 'Instructor';
        } elseif ($authUserModel instanceof Demonstrator) {
            $courses =  $authUserModel->courses;
        } else {
            $courses = Course::get();
        }

        return view('attendance.index', compact('batches', 'courses', 'authUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendance.create');
    }

    public function showAttendanceForm(AttendanceRequest $request)
    {
        $validated = $request->validated();

        $course = request('course');
        $batch = request('batch');
        $type = request('type');
        $today = Carbon::today();

        if (Attendance::isAttendanceLocked($today)) {
            return redirect()->route('home')->withError(__('Attendance marking is locked! Please contact MR to unlock the feature.'));
        }

        $courseDetails = Course::find(request('course'));
        
        $batchDetails = Batch::find(request('batch'));
                
        $currentYear = $today->year;
        $currentMonth = $today->month;
        $currentDay = 'day_' . $today->day;

        $trainees = Trainee::where([['course_id', '=', $course], ['batch_id', '=', $batch], ['status','<',2]])->select('id', 'image','name_with_initials', 'enrollment_no', 'nic')->get();
        $traineesIds = $trainees->modelKeys();
        $attendances = Attendance::where([['year','=',$currentYear],['month','=',$currentMonth],[$currentDay,'>',0]])->whereIn('trainee_id', $traineesIds)->select('trainee_id', $currentDay)->get();
        $todayAttendancesIds = $attendances->pluck('trainee_id')->toArray();


        //checking the logs for today
        $log =  DB::table('attendance_logs')->where([
            ['course_id', '=', $course],
            ['batch_id', '=', $batch],
            ['type','=',$type],
            ['created_at','=',$today],
        ])->orderBy('updated_at', 'desc')->first();

        
        if (count($attendances) == 0) {
            if (empty($log)) {
                return view('attendance.create', compact('trainees', 'courseDetails', 'batchDetails', 'type'));
            } else {
                return view('attendance.create', compact('trainees', 'courseDetails', 'batchDetails', 'type', 'log'));
            }
        } else {
            if ($attendances[0]->$currentDay == -1) {
                return view('attendance.create', compact('trainees', 'courseDetails', 'batchDetails', 'type'));
            } else {
                return view('attendance.create', compact('trainees', 'courseDetails', 'batchDetails', 'type', 'todayAttendancesIds', 'log'));
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendances = request('attendance');
        $dateTime = request('datetime');

        $year = Carbon::parse($dateTime)->year;
        $month = Carbon::parse($dateTime)->month;
        $date = 'day_' . Carbon::parse($dateTime)->day;
        $type = request('type');

        $batchId = request('batch');
        $courseId = request('course');

        $trainees = Trainee::where([['course_id', '=', $courseId], ['batch_id','=', $batchId],['status','<',2]])->pluck('id');
        $traineesAttedanceRecordsIds =  Attendance::whereIn('trainee_id', $trainees)->pluck('trainee_id');

        //create records for the trainees who does not have an initial attendance record and not marked first time
        //eg: for newly enrolled student
        $traineesNoAttedanceRecords =  Trainee::whereNotIn('id', $traineesAttedanceRecordsIds)->where([['course_id', '=', $courseId], ['batch_id','=', $batchId]])->pluck('id');
        if (!empty($traineesNoAttedanceRecords)) {
            foreach ($traineesNoAttedanceRecords as $traineesNoAttedanceRecord) {
                $record = new Attendance;
                $record->trainee_id = $traineesNoAttedanceRecord;
                $record->year = $year;
                $record->month = $month;
                $record->$date = -1;
                $record->save();
            }
        }

        //get the list of trainee attendacne records
        $traineesAttedanceRecords =  Attendance::whereIn('trainee_id', $trainees)->get();
        if (request('type') == 'Morning') {
            if (!empty($attendances)) {
                if (count($traineesAttedanceRecords) > 0) {
                    foreach ($traineesAttedanceRecords as $traineesAttedanceRecord) {
                        if (!in_array($traineesAttedanceRecord->trainee_id, $attendances)) {
                            $attendanceRecord = Attendance::where([['month', '=', $month], ['year', '=', $year], ['trainee_id', '=', $traineesAttedanceRecord->trainee_id]])->first();
                            if (!$attendanceRecord) {
                                $record = new Attendance;
                                $record->trainee_id = $traineesAttedanceRecord->trainee_id;
                                $record->year = $year;
                                $record->month = $month;
                                $record->$date = 0;
                                $record->save();

                                //for dropout warnings calculate
                                Dropout::updateOrCreate(
                                    ['trainee_id' => $traineesAttedanceRecord->trainee_id],
                                    ['no_of_absents' => (DB::raw('no_of_absents +1'))]
                                );
                            } else {
                                //for dropout warnings calculate
                                Dropout::updateOrCreate(
                                    ['trainee_id' => $traineesAttedanceRecord->trainee_id],
                                    ['no_of_absents' => (DB::raw('no_of_absents +1'))]
                                );
                                $attendanceRecord->$date = 0;
                                $attendanceRecord->save();
                            }
                        } else {
                            $attendanceRecord = Attendance::where([['month', '=', $month], ['year', '=', $year], ['trainee_id', '=', $traineesAttedanceRecord->trainee_id]])->first();
                            if (!$attendanceRecord) {
                                $record = new Attendance;
                                $record->trainee_id = $traineesAttedanceRecord->trainee_id;
                                $record->year = $year;
                                $record->month = $month;
                                $record->$date = 8;
                                $record->save();

                                Dropout::updateOrCreate(
                                    ['trainee_id' => $traineesAttedanceRecord->trainee_id],
                                    ['no_of_absents' => 0]
                                );
                            } else {
                                $attendanceRecord->$date = 8;
                                $attendanceRecord->save();

                                Dropout::updateOrCreate(
                                    ['trainee_id' => $traineesAttedanceRecord->trainee_id],
                                    ['no_of_absents' => 0]
                                );
                            }
                        }
                    }
                } else {
                    foreach ($trainees as $trainee) {
                        if (!in_array($trainee, $attendances)) {
                            $attendanceRecord = Attendance::where([['month', '=', $month], ['year', '=', $year], ['trainee_id', '=', $trainee]])->first();
                            if (!$attendanceRecord) {
                                $record = new Attendance;
                                $record->trainee_id = $trainee;
                                $record->year = $year;
                                $record->month = $month;
                                $record->$date = 0;
                                $record->save();

                                Dropout::updateOrCreate(
                                    ['trainee_id' => $trainee],
                                    ['no_of_absents' => (DB::raw('no_of_absents +1'))]
                                );
                            }
                        } else {
                            $attendanceRecord = Attendance::where([['month', '=', $month], ['year', '=', $year], ['trainee_id', '=', $trainee]])->first();
                            if (!$attendanceRecord) {
                                $record = new Attendance;
                                $record->trainee_id = $trainee;
                                $record->year = $year;
                                $record->month = $month;
                                $record->$date = 8;
                                $record->save();
                                
                                Dropout::updateOrCreate(
                                    ['trainee_id' => $trainee],
                                    ['no_of_absents' => 0]
                                );
                            }
                        }
                    }
                }
            } else {
                foreach ($trainees as $trainee) {
                    $attendanceRecord = Attendance::where([['month', '=', $month], ['year', '=', $year], ['trainee_id', '=', $trainee]])->first();
                    if (!$attendanceRecord) {
                        $record = new Attendance;
                        $record->trainee_id = $trainee;
                        $record->year = $year;
                        $record->month = $month;
                        $record->$date = 0;
                        $record->save();

                        Dropout::updateOrCreate(
                            ['trainee_id' => $trainee],
                            ['no_of_absents' => (DB::raw('no_of_absents +1'))]
                        );
                    } else {
                        Dropout::updateOrCreate(
                            ['trainee_id' => $trainee],
                            ['no_of_absents' => (DB::raw('no_of_absents +1'))]
                        );
                        
                        $attendanceRecord->$date = 0;
                        $attendanceRecord->save();
                    }
                }
            }
        } else {
            if (!empty($attendances)) {
                foreach ($traineesAttedanceRecords as $traineesAttedanceRecord) {
                    if (!in_array($traineesAttedanceRecord->trainee_id, $attendances)) {
                        $attendanceRecord = Attendance::where([['month', '=', $month], ['year', '=', $year], ['trainee_id', '=', $traineesAttedanceRecord->trainee_id]])->first();
                        $attendanceRecord->$date = 4;
                        $attendanceRecord->save();
                    }
                }
            } else {
                foreach ($traineesAttedanceRecords as $traineesAttedanceRecord) {
                    $attendanceRecord = Attendance::where([['month', '=', $month], ['year', '=', $year], ['trainee_id', '=', $traineesAttedanceRecord->trainee_id]])->first();
                    
                    if (!$attendanceRecord) {
                        $record = new Attendance;
                        $record->trainee_id = $traineesAttedanceRecord->trainee_id;
                        $record->year = $year;
                        $record->month = $month;
                        $record->$date = 4;
                        $record->save();
                    } else {
                        $attendanceRecord->$date = 4;
                        $attendanceRecord->save();
                    }
                }
            }
        }

        //count the daily percebtages as male, female
        $maleTrainees = Trainee::where([['course_id', '=', $courseId], ['batch_id','=', $batchId],['gender','=','male']])->pluck('id')->toArray();
        $femaleTrainees = Trainee::where([['course_id', '=', $courseId], ['batch_id','=', $batchId],['gender','=','female']])->pluck('id')->toArray();

        if (!empty($attendances)) {
            $todayMaleAttendanceCount = count(array_intersect($maleTrainees, $attendances));
            $todayFemaleAttendanceCount = count(array_intersect($femaleTrainees, $attendances));
        } else {
            $todayMaleAttendanceCount = 0;
            $todayFemaleAttendanceCount = 0;
        }
        
        

        if (count($maleTrainees) > 0) {
            $todayMaleAttendancePerc = $todayMaleAttendanceCount;
        } else {
            $todayMaleAttendancePerc = 0;
        }

        if (count($femaleTrainees) > 0) {
            $todayFemaleAttendancePerc = $todayMaleAttendanceCount;
        } else {
            $todayFemaleAttendancePerc = 0;
        }

        //adding the attendance_log
        DB::table('attendance_logs')->insert(
            ['user_id' => Auth::user()->id,
            'course_id' => $courseId,
            'batch_id' => $batchId,
            'type' => $type,
            'male_perc' => $todayMaleAttendancePerc,
            'female_perc' => $todayFemaleAttendancePerc,
            'created_at' => Carbon::now()->toDateString(),
            'updated_at' => Carbon::now()]
        );

        Dropout::suspendTrainees();
        Dropout::sendWarningDropoutNotification();
        return redirect()->route('attendance.index')->withStatus(__('Attendance successfully marked.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */

    public function showAttendanceSelectForm()
    {
        $batches = Batch::get();
        $courses = Course::get();
        $attendanceYears = Attendance::select('year')->distinct()->get();
        $attendanceMonths = Attendance::select('month')->distinct()->get();

        return view('attendance.select', compact('batches', 'courses', 'attendanceYears', 'attendanceMonths'));
    }

    public function showAttendanceViewForm(Request $request)
    {
        $batches = Batch::get();
        $courses = Course::get();
        $attendanceYears = Attendance::select('year')->distinct()->get();
        $attendanceMonths = Attendance::select('month')->distinct()->get();

        if ($request->has('nic')) {
            $request->validate([
                'nic' => 'required',
            ]);
            
            $nic = request('nic');
            $trainees = Trainee::where('nic', '=', request('nic'))->pluck('id');
            $attendances = Attendance::whereIn('trainee_id', $trainees)->get();
            return view('attendance.select', compact('attendances', 'batches', 'courses', 'attendanceYears', 'attendanceMonths', 'nic'));
        } else {
            $request->validate([
                'course' => 'required',
                'batch' => 'required',
                'year' => 'required',
                'month' => 'required',
            ]);
            $reCourse = request('course');
            $reBatch = request('batch');
            $reYear = request('year');
            $reMonth = request('month');

            $reCourseName = Course::find($reCourse)->course_name;
            $reBatchName = Batch::find($reBatch);

            $trainees = Trainee::where([['course_id', '=', $reCourse], ['batch_id', '=', $reBatch],['status','<',2]])->pluck('id');
            $attendances = Attendance::whereIn('trainee_id', $trainees)->where([['year','=',$reYear],['month','=',$reMonth]])->get();
            return view('attendance.select', compact('attendances', 'batches', 'courses', 'attendanceYears', 'attendanceMonths', 'reBatchName', 'reCourseName', 'reYear', 'reMonth'));
        }
    }


    public function showEligibiltyForm()
    {
        $batches = Batch::get();
        $courses = Course::get();
       
        return view('attendance.eligibility', compact('batches', 'courses'));
    }

    public function calculateEligibilty()
    {
        $batches = Batch::get();
        $courses = Course::get();

        $course = request('course');
        $batch = request('batch');

        $reCourseName = Course::find($course)->course_name;
        $reBatchName = Batch::find($batch);

        $trainees = Trainee::where([['course_id', '=', $course], ['batch_id', '=', $batch],['status','<',2]])->get();
        
        return view('attendance.eligibility', compact('trainees', 'batches', 'courses', 'reCourseName', 'reBatchName'));
    }
    
    public function show(Request $attendance)
    {
        return redirect('/');
    }

    public function reportDailyIndex()
    {
        $today = Carbon::today();
        
        $todayRecords =  DB::table('attendance_logs')->where([
        ['created_at','=',$today],
        ])->orderBy('updated_at', 'desc')->get()->unique('course_id');
       
        return view('attendance.report.daily', compact('todayRecords'));
    }
    

    public function reportDailySubmit(Request $request)
    {
        $request->validate([
            'report_date' => 'required',
        ]);

        $date = request('report_date');
        
        $todayRecords =  DB::table('attendance_logs')->where([
        ['created_at','=',$date],
        ])->orderBy('updated_at', 'desc')->get()->unique('course_id');
       
        return view('attendance.report.daily', compact('todayRecords', 'date'));
    }

    public function reportMonthlyIndex()
    {
        $batches = Batch::get();
        $courses = Course::get();
        $attendanceYears = Attendance::select('year')->distinct()->get();
        $attendanceMonths = Attendance::select('month')->distinct()->get();

        return view('attendance.report.monthly', compact('batches', 'courses', 'attendanceYears', 'attendanceMonths'));
    }

    public function reportMonthlySubmit(Request $request)
    {
        $batches = Batch::get();
        $courses = Course::get();
        $attendanceYears = Attendance::select('year')->distinct()->get();
        $attendanceMonths = Attendance::select('month')->distinct()->get();

        $request->validate([
                'course' => 'required',
                'batch' => 'required',
                'year' => 'required',
                'month' => 'required',
            ]);

        $reCourse = request('course');
        $reBatch = request('batch');
        $reYear = request('year');
        $reMonth = request('month');

        $reCourseName = Course::find($reCourse)->course_name;
        $reBatchName = Batch::find($reBatch);

        $avgPrec = DB::table('attendance_logs')->whereMonth('created_at', $reMonth)
                ->where([['course_id','=',$reCourse],['batch_id','=',$reBatch],['type','=','Morning']])
                ->select(DB::raw('avg(male_perc) male_perc, avg(female_perc) female_perc'))->first();
        
        $trainees = Trainee::where([['course_id', '=', $reCourse], ['batch_id', '=', $reBatch],['status','<',2]])->pluck('id');
        $attendances = Attendance::whereIn('trainee_id', $trainees)->where([['year','=',$reYear],['month','=',$reMonth]])->get();

        return view('attendance.report.monthly', compact('attendances', 'batches', 'courses', 'attendanceYears', 'attendanceMonths', 'reBatchName', 'reCourseName', 'reYear', 'reMonth', 'avgPrec'));
    }

    public function addAttendancePermission()
    {
        if (auth()->user()->level() > 3) {
            $instructors = Instructor::select('id', 'first_name', 'last_name')->get();
            $unlockedRecords = DB::table('attendance_permissions')->orderBy('created_at', 'desc')->get();
    
            return view('attendance.permission.permission', compact('instructors', 'unlockedRecords'));
        } else {
            abort(403);
        }
    }

    public function addAttendancePermissionSubmit(Request $request)
    {
        if (auth()->user()->level() > 3) {
            DB::table('attendance_permissions')->insert(
                ['user_id' => Instructor::find(request('instructor'))->user_id,
            'allow' => 1,
            'created_at' => request('date'),
            'updated_at' => Carbon::now()]
            );
            return redirect()->route('attendance.permission.add')->withStatus(__('Permission successfully allocated.'));
        } else {
            abort(403);
        }
    }
}
