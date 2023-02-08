<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\School;
use App\Models\Approval;
use App\Models\Response;
use App\Models\SboOfficer;
use App\Models\Notification;
use App\Models\SocialAccount;
use App\Models\CampusDirector;
use App\Models\CampusSboAdviser;
use App\Models\SboAdviserRequest;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'first_name',
    //     'last_name',
    //     'email',
    //     'password',
    //     'access_token' 
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function socialAccounts(){
        return $this->hasMany(SocialAccount::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
    }


    public function schools(){
        return $this->belongsToMany(School::class, 'school_users', 'user_id', 'school_id');
    }

    public function sboRequest(){
        return $this->hasOne(SboAdviserRequest::class);
    }



   

    public function responses(){
        return $this->hasMany(Response::class);
    }

    public function approvals(){
        return $this->hasMany(Approval::class);
    }

   
    public function notifications(){


        return $this->belongsToMany(Notification::class , 'users_notifications' ,  'user_id', 'notification_id');


    }


    public function receivedNotifications()
    {
        return $this->hasMany(Notification::class, 'recipient_id');
    }



    public function campus_sbo_advisers(){
        return $this->hasMany(CampusSboAdviser::class);
    }
    
    public function sbo_officers(){
        return $this->hasMany(SboOfficer::class, 'student_id');
    }
    public function sbo_officer(){
        return $this->hasOne(SboOfficer::class, 'student_id');
    }

    public function campus_directors(){
        return $this->hasMany(CampusDirector::class);
    }
    
    public function campus_director(){
        return $this->hasOne(CampusDirector::class);
    }

}
