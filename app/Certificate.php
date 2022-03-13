<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }
}