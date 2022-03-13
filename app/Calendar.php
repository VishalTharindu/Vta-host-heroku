<?php

namespace App;

use Carbon;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    public static function isTodayHoliday()
    {
        $date = Carbon\Carbon::today()->toDateString();
        $holiday = Calendar::where('start', '=', $date)->get();
        if (count($holiday) != 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getCurrentMonthHolidays(){
        $date = now();
        $currentMonth = date('m');
        $currentMonthHolidays = Calendar::whereRaw('MONTH(created_at) = ?',[$currentMonth])->count();
        return $currentMonthHolidays;
    }

    public static function getCurrentUpcommingMonthHoliday(){
        $date = now();
        $currentUpcommingMonthHoliday = Calendar::whereMonth('start', '>', $date->month)
        ->orWhere(function ($query) use ($date) {
            $query->whereMonth('start', '=', $date->month)->whereDay('start', '>=', $date->day);
        })
        ->orderByRaw("DAYOFMONTH('start')",'ASC')->take(2)->select('title')->get();
        return  $currentUpcommingMonthHoliday;
    }
}
