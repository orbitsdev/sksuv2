<?php

namespace App\Models;

use App\Models\User;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Endorsement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CampusDean extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function school_year(){
        return $this->belongsTo(SchoolYear::class);
    }


    public function user(){
        return $this->belongsTo(User::class);
    }


    public function school(){
        return $this->belongsTo(School::class);
    }


    public function endorsements(){
        return $this->hasMany(Endorsement::class, 'reciever_id');
    }
}
