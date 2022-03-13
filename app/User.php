<?php

namespace App;

use App\Instructor;
use App\Demonstrator;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','user_type','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    //get the user model
    public function getUserModel()
    {
        $userType = $this->user_type;

        if ($userType == 'Instructor') {
            $model = Instructor::where('user_id', '=', $this->id)->first();
        } elseif ($userType == 'Demonstrator') {
            $model = Demonstrator::where('user_id', '=', $this->id)->first();
        }
        // build else if later
        else {
            return null;
        }

        return $model;
    }

    public static function getUserName($id)
    {
        return User::find($id)->name;
    }
}
