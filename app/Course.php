<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function applicants()
    {
        return $this->belongsToMany(Applicant::class);
    }

    public function trainees()
    {
        return $this->hasMany(Trainee::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function demonstrators()
    {
        return $this->belongsToMany(Demonstrator::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function preassesments()
    {
        return $this->belongsTo(PreAssesment::class);
    }

    public function coursedurations()
    {
        return $this->hasMany(CourseDuration::class);
    }

    public function examinationpayment()
    {
        return $this->hasMany(ExaminationPayment::class);
    }
}
