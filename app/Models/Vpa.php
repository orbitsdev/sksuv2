<?php

namespace App\Models;

use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Vpa extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function school_year(){

        return $this->belongsTo(SchoolYear::class);
    }


    public function user(){
        return $this->belongsTo(User::class);
    } 



}
