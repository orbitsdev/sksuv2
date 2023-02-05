<?php

namespace App\Models;

use App\Models\School;
use App\Models\SchoolYear;
use App\Models\CampusSboAdviser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schools(){
        return $this->belongsToMany(School::class, 'school_departments', 'department_id', 'school_id');
    }

    public function officers(){
        return $this->hasMany(SboOfficer::class, 'department_id');
    }


    // public function campus_sbo_adviser(){
    //     return $this->belongsTo(CampusSboAdviser::class);
    // }

    

    public function school(){
        return $this->belongsTo(School::class);
    }

    

    


}
