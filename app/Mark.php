<?php

namespace App;
use App\Examination;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    public function trainees()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function subject()
    {
        return $this->belongsTo(Trainee::class);
    }

    public static function traineeAttemptWiseConfidentLevel($traineeId, $subjectId, $attempt){

        $mark = Mark::where([['trainee_id', '=' ,$traineeId], ['subject_id', '=', $subjectId],['attempt', '=', $attempt]])->orderBy('created_at','desc')->first();
        $confidLevel = 0;
        if (empty($mark)) {
            return $confidLevel;
        } else {
            $confidLevel = ($mark->Wmarks) + ($mark->Pmarks);
            return $confidLevel ;
        }
        
    }

    public static function traineeWrittenSubjectsMarks($traineeId, $subjectId){

        $mark = Mark::where([['trainee_id', '=' ,$traineeId], ['subject_id', '=', $subjectId]])->orderBy('created_at','desc')->first();

        if (empty($mark)) {
            return 'N/A';
        }else{
            return $mark->Wmarks;
        }
        
    }

    public static function traineePracticleSubjectsMarks($traineeId, $subjectId){

        $mark = Mark::where([['trainee_id', '=' ,$traineeId], ['subject_id', '=', $subjectId]])->orderBy('created_at','desc')->first();

        if (empty($mark)) {
            return 'N/A';
        }else{
            return $mark->Pmarks;
        }
        
    }

    public static function traineeConfidentLevel($traineeId, $subjectId){
        $mark = Mark::where([['trainee_id', '=' ,$traineeId], ['subject_id', '=', $subjectId]])->orderBy('created_at','desc')->first();
        $confidLevel = 0;
        if (empty($mark)) {
            return $confidLevel;
        } else {
            $confidLevel = ($mark->Wmarks) + ($mark->Pmarks);
            return $confidLevel ;
        }
        
    }

    public static function subjectOverallResultHelper($traineeId, $subjectId){

        $mark = Mark::where([['subject_id', $subjectId], ['trainee_id', $traineeId]])->orderBy('created_at','desc')->first();

        $total = ($mark->Wmarks) + ($mark->Pmarks);

        return $total;


    }

    
    public static function calculateSubjectPassPresentage($subjectId ,$batchid){

        $traineeID = Mark::where([['subject_id', $subjectId], ['batch_id', $batchid]])->groupBy('trainee_id')->pluck('trainee_id');
        $total = 0;
        $allmark = 0;

        if (count($traineeID) == 0) {
            return 0.00;
        }else{

            foreach ($traineeID as $traineeId) {

                $mark = Mark::subjectOverallResultHelper($traineeId,$subjectId);

                if ($mark >= 80 ) {
                    $total += 1;
                }

                $allmark += 1;
            }
    
            $answer = round((($total/$allmark)*100),2);
            return $answer ;
        }
        
    }
    public static function calculateSubjectFailPresentage($subjectId, $batchid){

        $traineeID = Mark::where([['subject_id', $subjectId], ['batch_id', $batchid]])->groupBy('trainee_id')->pluck('trainee_id');
        $total = 0;
        $allmark = 0;

        if (count($traineeID) == 0) {
            return 0.00;
        }else{

            foreach ($traineeID as $traineeId) {

                $mark = Mark::subjectOverallResultHelper($traineeId, $subjectId);

                if ($mark < 80 ) {
                    $total += 1;
                }

                $allmark += 1;
            }
    
            $answer = round((($total/$allmark)*100),2);
            return $answer ;
        }
    }

    public static function calculateOverallSubjectPassPresentage($subjectId, $course, $batch){

        $marks = Mark::where([['subject_id', $subjectId], ['type', '=', 'P']])->get();
        $total = 0;
        $allmark = 0;

        if (count($marks) == 0) {
            return 0.00;
        }else{

            foreach ($marks as $mark) {
                
                if (($mark->marks > 35)) {
                    $total += 1;                  
                }

                $allmark += 1;
            }

            $answer = round((($total/$allmark)*100),2);
            return $answer ;
        }
        
    }

    public static function calculateOverallSubjectFailPresentage($subjectId, $course, $batch){

        $marks = Mark::where([['subject_id', $subjectId], ['type', '=', 'P']])->get();
        $total = 0;
        $allmark = 0;

        if (count($marks) == 0) {
            return 0.00;
        }else{

            foreach ($marks as $mark) {
                
                if (($mark->marks < 35) || ($mark->marks == 'N/A')) {
                    $total += 1;                  
                }

                $allmark += 1;
            }

            $answer = round((($total/$allmark)*100),2);
            return $answer ;
        }
    }
}
