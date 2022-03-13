<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseDuration extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
