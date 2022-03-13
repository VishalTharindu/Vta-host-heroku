<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExaminationPayment extends Model
{
    public function trainees()
    {
        return $this->belongsTo(Trainee::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public static function unpaiedTrainess($traineeid){

        $payment_status = ExaminationPayment::where('trainee_id', '=' ,$traineeid)->orderBy('created_at','desc')->first();

        if (empty($payment_status)) {
            return true;
        }else{
            if ($payment_status->payment_status == 0) {
                return true;
            }else {
                return false;
            }
        }
    }

    public static function paiedTrainess($traineeid){

        $payment_status = ExaminationPayment::where('trainee_id', '=' ,$traineeid)->orderBy('created_at','desc')->first();

        if (empty($payment_status)) {
            return false;
        }else{
            if ($payment_status->payment_status == 1) {
                return true;
            }else {
                return false;
            }
        }
    }
}
