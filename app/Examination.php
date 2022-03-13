<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    public static function traineeCurrentStatus($traineeid){

        $status = Examination::where([['trainee_id', '=' ,$traineeid], ['type', '=', 'W']])->orderBy('created_at','desc')->first();

        if (empty($status)) {
            return false;
        }else{
            return true;

        }
        
    }

    public static function traineePassFailStatus($traineeid){

        $status = Examination::where([['trainee_id', '=' ,$traineeid], ['type', '=', 'W']])->orderBy('created_at','desc')->first();

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

        $attempt = Examination::where('trainee_id', '=' ,$traineeid)->orderBy('created_at','desc')->first();

        if (empty($attempt)) {
            return 3;
        }else{
            // if ($attempt->type == 'W' && $attempt->status == 1) {
            //     $attempt = (($attempt->attempt) - 1);
            // }elseif ($attempt->type == 'P' && $attempt->status == 1) {
            //     $attempt = (($attempt->attempt) - 1);
            // }else{
            //     $attempt = (($attempt->attempt) - 1);
            // }
            return ($attempt->attempt) - 1 ;
        }
    }

    public static function resultCount($requiredCourse, $requiredBatch){

        $result = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['type', '=', 'W']])->orderBy('trainee_id','desc')->groupBy('trainee_id')->pluck('trainee_id');
        $numberOfItem = count($result);
        return $numberOfItem;
    }

    public static function traineeOverallResultHelper($status){
        $traineestatus = Examination::where('trainee_id', '=', $status)->select('status')->orderBy('created_at','desc')->first();
        return $traineestatus;
    }

    public static function calculatePassPrecentage($requiredCourse, $requiredBatch){

        $result = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['type', '=', 'W']])->groupBy('trainee_id')->pluck('trainee_id');
        $numberOfResult = count($result);
        $numberOfPassItem = 0;
        if ($numberOfResult == 0) {

            return 0.00;
            
        }else{
            foreach ($result as $value) {
                $status = Examination::traineeOverallResultHelper($value);

                if ($status->status == 1) {

                    $numberOfPassItem += 1;
                }
                
            }
            $numberOfItem = Examination::resultCount($requiredCourse, $requiredBatch);         
            $passrate = ($numberOfPassItem/$numberOfItem) * 100;
            
            return round($passrate,2);
        }
    }

    public static function calculateFailPrecentage($requiredCourse, $requiredBatch){

        $result = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['type', '=', 'W']])->groupBy('trainee_id')->pluck('trainee_id');
        $numberOfResult = count($result);
        $numberOfPassItem = 0;
        if ($numberOfResult == 0) {

            return 0.00;
            
        }else{
            foreach ($result as $value) {
                $status = Examination::traineeOverallResultHelper($value);

                if ($status->status == 0) {

                    $numberOfPassItem += 1;
                }
                
            }
            $numberOfItem = Examination::resultCount($requiredCourse, $requiredBatch);         
            $passrate = ($numberOfPassItem/$numberOfItem) * 100;
            
            return round($passrate,2);
        }
    }

    public static function traineePracticlStatus($traineeid){

        $status = Examination::where([['trainee_id', '=' ,$traineeid], ['type', '=', 'P']])->orderBy('created_at','desc')->first();

        if (empty($status)) {
            return false;
        }else{
            if ($status->status == 0) {
                return false;
            }else {
                return true;
            }
        }
        
    }

    public static function calculatePassPrecentageFinal($requiredCourse, $requiredBatch){

        $result = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['type', '=', 'P']])->groupBy('trainee_id')->pluck('trainee_id');
        $numberOfResult = count($result);
        $numberOfPassItem = 0;
        if ($numberOfResult == 0) {

            return 0.00;
            
        }else{
            foreach ($result as $value) {
                $status = Examination::traineeOverallResultHelper($value);

                if ($status->status == 1) {

                    $numberOfPassItem += 1;
                }
                
            }
            $numberOfItem = Examination::resultCount($requiredCourse, $requiredBatch);         
            $passrate = ($numberOfPassItem/$numberOfItem) * 100;
            
            return round($passrate,2);
        }
    }

    public static function calculateFailPrecentageFinal($requiredCourse, $requiredBatch){

        $result = Examination::where([['course_id', '=', $requiredCourse], ['batch_id', '=', $requiredBatch], ['type', '=', 'P']])->groupBy('trainee_id')->pluck('trainee_id');
        $numberOfResult = count($result);
        $numberOfPassItem = 0;
        if ($numberOfResult == 0) {

            return 0.00;
            
        }else{
            foreach ($result as $value) {
                $status = Examination::traineeOverallResultHelper($value);

                if ($status->status == 0) {

                    $numberOfPassItem += 1;
                }
                
            }
            $numberOfItem = Examination::resultCount($requiredCourse, $requiredBatch);         
            $passrate = ($numberOfPassItem/$numberOfItem) * 100;
            
            return round($passrate,2);
        }
    }
}
