<?php

namespace App;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection; 

class Attendance extends Model
{
    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }

    public static function calculateAttendacnePercentage($attendance)
    {
        $totalAttendanceMarkedDays = 0;
        $traineeAttendanceScore = 0;

        for ($i = 1; $i < 32; $i++) {
            $day='day_' . $i;
            if ($attendance->$day == '0' || $attendance->$day == '8' || $attendance->$day == '4') {
                $totalAttendanceMarkedDays++;
                $traineeAttendanceScore = $traineeAttendanceScore + $attendance->$day;
            }
        }
        $totalAttendanceScore = $totalAttendanceMarkedDays * 8;
        $traineeAttendancePercentage = ($traineeAttendanceScore/$totalAttendanceScore) * 100;
        return round($traineeAttendancePercentage, 2);
    }

    public static function calculateMonthlyAttendanceEligibility($traineeId, $month)
    {
        $attendanceRecord = Attendance::where([['trainee_id', $traineeId],['month', $month]])->first();
        
        //error handling for no attendance record trainee
        if (empty($attendanceRecord)) {
            return 0.00;
        }

        $totalPercentage = Attendance::calculateAttendacnePercentage($attendanceRecord);
        return $totalPercentage;
    }

    public static function calculateAttendanceEligibility($traineeId)
    {
        $totalPercentage = 0;
        $attendanceRecords = Attendance::where('trainee_id', $traineeId)->get();

        //error handling for no attendance record trainee
        if (count($attendanceRecords) == 0) {
            return 0.00;
        }

        foreach ($attendanceRecords as $attendanceRecord) {
            $totalPercentage += Attendance::calculateAttendacnePercentage($attendanceRecord);
        }
        $totalAttendanceRecords = count($attendanceRecords);
        $averageAttendancePrecentage = $totalPercentage / $totalAttendanceRecords;
        return round($averageAttendancePrecentage, 2);
    }

    public static function isAttendanceLocked($date)
    {
        $permissionRecord = DB::table('attendance_permissions')->where([
            ['user_id', '=', auth()->user()->id],
            ['created_at','=',$date],
        ])->orderBy('updated_at', 'desc')->first();

        $time = Carbon::now()->format('H:i');
        if ((!empty($permissionRecord)) && $time > '10.00') {
            return false;
        } elseif ($time < '10.00') {
            return false;
        } else {
            return true;
        }
    }

    public static function returnTotalAttendanceMarkedDays($traineeId){

        $traineeAttendanceRecord = Attendance::where('trainee_id',$traineeId)->first();
        $totalAttendanceMarkedDays = 0;
    
        for ($i = 1; $i < 32; $i++) {
            $day='day_' . $i;
            if ($traineeAttendanceRecord->$day == '0' || $traineeAttendanceRecord->$day == '8' || $traineeAttendanceRecord->$day == '4') {
                $totalAttendanceMarkedDays++;
            }
        }

        return $totalAttendanceMarkedDays;

    }

    public static function returnTodayMaleAttendanceCount(){
        $today = Carbon::today();
        
        $todayRecords =  DB::table('attendance_logs')->where([
        ['created_at','=',$today],
        ])->orderBy('updated_at', 'desc')->select('male_perc')->get()->unique('course_id');
        
        $totalMaleCount = 0;
        foreach($todayRecords as $todayRecord){
            $totalMaleCount = $totalMaleCount + $todayRecord->male_perc;
        }

        return $totalMaleCount;
    }

    public static function returnTodayFemaleAttendanceCount(){
        $today = Carbon::today();
        
        $todayRecords =  DB::table('attendance_logs')->where([
        ['created_at','=',$today],
        ])->orderBy('updated_at', 'desc')->select('female_perc')->get()->unique('course_id');
        
        $totalFemaleCount = 0;
        foreach($todayRecords as $todayRecord){
            $totalFemaleCount = $totalFemaleCount + $todayRecord->female_perc;
        }

        return $totalFemaleCount;
    }

    public static function returnTodayTotalAttendanceCount($courseId){
        $today = Carbon::today();
        
        $todayRecord =  DB::table('attendance_logs')->where([
        ['created_at','=',$today],
        ['course_id','=',$courseId]])->orderBy('updated_at', 'desc')->select('female_perc','male_perc')->get()->unique('course_id');
        $totalCount = 0;

        if(count($todayRecord) > 0){
            $totalCount = intval($todayRecord[0]->male_perc) + intval($todayRecord[0]->female_perc);  
        }
        return $totalCount;
    }

}
