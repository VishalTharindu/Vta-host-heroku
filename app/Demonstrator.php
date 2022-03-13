<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demonstrator extends Model
{
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function hasCourses($courseId)
    {
        return in_array($courseId,$this->courses->pluck('id')->toarray());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getDemonstratorCount(){
        return Demonstrator::count();
    }
}
