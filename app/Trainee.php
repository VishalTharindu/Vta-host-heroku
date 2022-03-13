<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Trainee extends Model
{
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function funds()
    {
        return $this->belongsToMany(Fund::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function preassestmentmarks()
    {
        return $this->hasMany(Mark::class);
    }

    public function dropout()
    {
        return $this->belongsTo(Dropout::class);
    }

    public function trainingInstitute()
    {
        return $this->belongsTo(TrainingInstitute::class);
    }

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }

    public function hasFunds($fundId)
    {
        return in_array($fundId, $this->funds->pluck('id')->toarray());
    }

    public function examinationpayment()
    {
        return $this->hasOne(ExaminationPayment::class);
    }

    //To get the trainee male count
    public function maleCount($trainees)
    {
        return $trainees->where('gender', 'male')->count();
    }

    //To get thetrainee female count
    public function femaleCount($trainees)
    {
        return $trainees->where('gender', 'female')->count();
    }

    //Filter according to both batch and course
    public function filter($filterBatch, $filterCourse)
    {
        return Trainee::where([
            ['status', '!=', 2],
            ['batch_id', '=', $filterBatch],
            ['course_id', '=', $filterCourse],
        ])->get();
    }

    //Filter according to course
    public function filterCourse($filterCourse)
    {
        return Trainee::where([
            ['status', '!=', 2],
            ['course_id', '=', $filterCourse]
        ])->get();
    }

    //Filter according to both batch
    public function filterBatch($filterBatch)
    {
        return Trainee::where([
            ['status', '!=', 2],
            ['batch_id', '=', $filterBatch]
        ])->get();
    }
}