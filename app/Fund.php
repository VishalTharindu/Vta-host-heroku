<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Fund extends Model
{
    public function trainees()
    {
        return $this->belongsToMany(Trainee::class);
    }

    public static function fundReallocation($traineeId , $fundId)
    {
        $fundrecord = DB::table('fund_trainee')->where([['trainee_id', $traineeId],['fund_id', $fundId]])->get();
        
        if (!$fundrecord->isEmpty()) {
            return 1;
        }
        else{
            return 0;
        }
    }
}
