<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingInstitute extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address','phone_no',
    ];


    public function trainees()
    {
        return $this->hasMany(Trainee::class);
    }
}
