<?php

namespace App\Models;

use App\Models\Vpa;
use App\Models\School;
use App\Models\CampusDean;
use App\Models\CampusDirector;
use App\Models\ApplicationForm;
use App\Models\CampusSboAdviser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolYear extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function schools(){
        return $this->hasMany(School::class);
    }


    public function campus_sbo_advisers(){
        return $this->hasMany(CampusSboAdviser::class);
    }



    

    public function application_forms(){
        return $this->hasMany(ApplicationForm::class);
    }


    public function campus_directors(){
        return $this->hasMany(CampusDirector::class);
    }
    public function campus_deans(){
        return $this->hasMany(CampusDean::class);
    }


    public function vpas(){
        return $this->hasMany(Vpa::class);
    }


    
}
