<?php

namespace App;

use App\Trainee;
use Illuminate\Database\Eloquent\Model;
use jeremykenedy\LaravelRoles\Models\Role as Role;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DropoutNotification;

class Dropout extends Model
{
    protected $fillable = [
        'trainee_id', 'no_of_absents',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }


    public static function sendWarningDropoutNotification()
    {
        $newDropoutsCount = Dropout::where([['no_of_absents','=',14],['letter_issued',0]])->count();

        if ($newDropoutsCount > 0) {
            $MA = Role::where('name', '=', 'ma')->first();
            $OIC = Role::where('name', '=', 'oic')->first();
            $MR = Role::where('name', '=', 'mr')->first();
    
            //notification to MA
            Notification::send($MA->users, new DropoutNotification($newDropoutsCount));
    
            //notification to OIC
            Notification::send($OIC->users, new DropoutNotification($newDropoutsCount));
    
            //notification to MR
            Notification::send($MR->users, new DropoutNotification($newDropoutsCount));
        }
    }

    public static function suspendTrainees()
    {
        $suspenedTrainees = Dropout::where([['no_of_absents','=',30],['letter_issued',1]])->pluck('trainee_id');


        //remove trainees from the active status
        foreach ($suspenedTrainees as $suspenedTrainee) {
            $trainee = Trainee::find($suspenedTrainee);
            $trainee->status = 2;
            $trainee->update();
        }

        $suspenedTraineesCountNotification = 'suspended-'.count($suspenedTrainees);

        if (count($suspenedTrainees) > 0) {
            $MA = Role::where('name', '=', 'ma')->first();
            $OIC = Role::where('name', '=', 'oic')->first();
            $MR = Role::where('name', '=', 'mr')->first();
    
            //notification to MA
            Notification::send($MA->users, new DropoutNotification($suspenedTraineesCountNotification));
    
            //notification to OIC
            Notification::send($OIC->users, new DropoutNotification($suspenedTraineesCountNotification));
    
            //notification to MR
            Notification::send($MR->users, new DropoutNotification($suspenedTraineesCountNotification));
        }
    }

    public static function getTrainneRecord($id)
    {
        return Trainee::find($id);
    }

    //check course leave letters is issued or not
    public static function leaveLetterStatus($traineeId)
    {
        $status =  Dropout::where('trainee_id', $traineeId)->pluck('suspend_letter')->first();
        return $status;
    }

    public static function returnLeaveLetter($traineeId)
    {
        $file =  Dropout::where('trainee_id', $traineeId)->pluck('suspend_letter_file')->first();
        return $file;
    }

    public static function returnDropoutWarningsCount(){
        $count = Dropout::where([['no_of_absents','=',14],['letter_issued',1]])->count();
        return $count;
    }

    public static function getDropoutsCount(){
        return Dropout::where([['no_of_absents','=',14],['letter_issued',1]])->count();
    }

    public static function getSuspenedCount(){
        return Dropout::where([['no_of_absents','=',30],['suspend_letter',1]])->count();
    }

}
