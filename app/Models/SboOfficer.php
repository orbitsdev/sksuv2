<?php

namespace App\Models;

use App\Models\User;
use App\Models\School;
use App\Models\Department;
use App\Models\CampusSboAdviser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SboOfficer extends Model
{
    use HasFactory;

    protected $guarded = [];

    


    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }


    public function userSchool(){
        return $this->hasManyThrough(School::class, SboOfficer::class, 'adviser_id', '');
    }

    public function campus_sbo_adviser(){
        return $this->belongsTo(CampusSboAdviser::class);
    }



    public function school(){
        return $this->belongsTo(School::class);
    }
    

}
