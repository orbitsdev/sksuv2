<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SboOfficer extends Model
{
    use HasFactory;

    protected $guarded = [];

    
    public function adviser(){
        
        return $this->belongsTo(User::class, 'adviser_id');
    }

    public function student(){
        return $this->belongsTo(User::class, 'student_id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }


    public function userSchool(){
        return $this->hasManyThrough(School::class, SboOfficer::class, 'adviser_id', '');
    }


    

}
