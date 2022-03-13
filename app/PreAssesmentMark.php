<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreAssesmentMark extends Model
{
    public function trainees()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function subject()
    {
        return $this->belongsTo(Trainee::class);
    }

    public static function traineeSubjectsMarks($traineeId, $subjectId){

        $mark = PreAssesmentMark::where([['trainee_id', '=' ,$traineeId], ['subject_id', '=', $subjectId]])->orderBy('created_at','desc')->first();

        if (empty($mark)) {
            return 'N/A';
        }else{
            return $mark->preasses_marks;
        }
        
    }
    
    public static function calculateSubjectPassPresentage($subjectId){

        $marks = PreAssesmentMark::where('subject_id', $subjectId)->get();
        $total = 0;
        $allmark = 0;

        if (count($marks) == 0) {
            return 0.00;
        }else{

            foreach ($marks as $mark) {
                
                if ($mark->preasses_marks == 'C' ) {
                    $total += 1;
                }

                $allmark += 1;
            }
    
            $answer = round((($total/$allmark)*100),2);
            return $answer ;
        }
        
    }
    public static function calculateSubjectFailPresentage($subjectId){

        $marks = PreAssesmentMark::where('subject_id', $subjectId)->get();
        $total = 0;
        $allmark = 0;
        if (count($marks) == 0) {
            return 0.00;
        }else{

            foreach ($marks as $mark) {

                if ($mark->preasses_marks == 'NC' ) {
                    $total += 1;
                    
                }

                $allmark += 1;
            }
    
            $answer = round((($total/$allmark)*100),2);
            return $answer ;
        }
    }
}
