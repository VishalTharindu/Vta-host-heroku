<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function preassestmentmarks()
    {
        return $this->hasMany(Mark::class);
    }

    
    public static function matchTraineeSubject($courseId, $subject)
    {
        $subjects = Subject::where('course_id', '=' ,$courseId);

        foreach ($subjects as  $value) {
            if ($value->id == $subject) {
                
                return true;
            }
        }
    }
}
