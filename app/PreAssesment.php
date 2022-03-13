<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PreAssesment extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public static function dateComparision($prsId){
        
        $currentdate = Carbon::now()->toDateString();
        $preassDate = PreAssesment::where([['id', '=', $prsId],['status', '!=', 1]])->pluck('date')->first();
        if ($currentdate == $preassDate) {
            return 'today';
        } elseif($currentdate > $preassDate) {
            return 'overdue';
        } else{
            $left = Carbon::parse($preassDate)->diffForHumans();
            return $left;
        }  
        
    }

}
