<?php

namespace App\Models;

use App\Models\File;
use App\Models\User;
use App\Models\Response;
use App\Models\CampusDean;
use App\Models\Department;
use App\Models\SboOfficer;
use App\Models\SchoolYear;
use App\Models\CampusSboAdviser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;
    protected $guarded = [];



  


    public function files()
    {
        return $this->belongsToMany(File::class, 'school_files', 'school_id', 'file_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'school_users', 'school_id', 'user_id');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'school_departments', 'school_id', 'department_id');
    }

 
    
    public function sboOfficers()
    {
        return $this->hasManyThrough(
            SboOfficer::class,
            User::class,
            'id', // Foreign key on users table...
            'adviser_id', // Foreign key on sbo_officers table...
            'id', // Local key on schools table...
            'id' // Local key on users table...
        );
    }



    public function campus_sbo_advisers(){
        return $this->hasMany(CampusSboAdviser::class);
    }

    public function deparments(){
        return $this->hasMany(Department::class);  
    }

    public function school_year(){
        return $this->belongsTo(SchoolYear::class);
    }


    public function sbo_offcers(){
        return $this->hasMany(SboOfficer::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }

    public function campus_directors(){
        return $this->hasMany(CampusDirector::class);
    }
    public function campus_deans(){
        return $this->hasMany(CampusDean::class);
    }

}

