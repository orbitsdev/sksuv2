<?php

namespace App\Models;

use App\Models\School;
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


    

    
}
