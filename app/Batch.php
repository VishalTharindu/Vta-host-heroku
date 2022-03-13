<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    public function trainees()
    {
        return $this->hasMany(Trainee::class);
    }

    public function batchName($id)
    {
        return Batch::where('id', $id)->first();
    }

    public function coursedurations()
    {
        return $this->hasMany(CourseDuration::class);
    }

    public function preassesments()
    {
        return $this->belongsTo(PreAssesment::class);
    }

    public function examinationpayment()
    {
        return $this->hasMany(ExaminationPayment::class);
    }
}
