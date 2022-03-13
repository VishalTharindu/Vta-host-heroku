<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreAssesmentRsult extends Model
{
    public static function traineeCurrentStatus($traineeid){

        $status = PreAssesmentRsult::where('trainee_id', '=' ,$traineeid)->orderBy('created_at','desc')->first();

        if (empty($status)) {
            return false;
        }else{
            return true;

        }
        
    }

    public static function traineeFirsttimeEligibility($traineeid){

        $status = PreAssesmentRsult::where('trainee_id', '=' ,$traineeid)->orderBy('created_at','desc')->first();

        if (empty($status)) {
            return true;
        }else{
            return false;

        }
        
    }

    public static function traineePassFailStatus($traineeid){

        $status = PreAssesmentRsult::where('trainee_id', '=' ,$traineeid)->orderBy('created_at','desc')->first();

        if (empty($status)) {
            return true;
        }else{
            if ($status->status == 0) {
                return true;
            }else {
                return false;
            }
        }
        
    }

    public static function traineeCurrentAttempt($traineeid){

        $attempt = PreAssesmentRsult::where('trainee_id', '=' ,$traineeid)->orderBy('created_at','desc')->first();

        if (empty($attempt)) {
            return 3;
        }else{
            $attempt = (($attempt->attempt) - 1);
            return $attempt;
        }
    }

    public static function resultCount($requiredCourse, $requiredBatch){

        $result = PreAssesmentRsult::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch]])->get();
        $numberOfItem = count($result);
        return $numberOfItem;
    }

    public static function calculatePassPrecentage($requiredCourse, $requiredBatch){

        $result = PreAssesmentRsult::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['status', '=', 1]])->get();
        $numberOfPassItem = count($result);

        if ($numberOfPassItem == 0) {

            return 0.00;
            
        }else{
            $numberOfItem = PreAssesmentRsult::resultCount($requiredCourse, $requiredBatch);
    
            $passrate = ($numberOfPassItem/$numberOfItem) * 100;
            
            return round($passrate,2);
        }
    }

    public static function calculateFailPrecentage($requiredCourse, $requiredBatch){

        $result = PreAssesmentRsult::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['status', '=', 0]])->get();
        $numberOfPassItem = count($result);

        if ($numberOfPassItem == 0) {
            return 0.00;
        }else{
            $numberOfItem = PreAssesmentRsult::resultCount($requiredCourse, $requiredBatch);
    
            $passrate = ($numberOfPassItem/$numberOfItem) * 100;
            
            return round($passrate,2);
        }
    }
}
