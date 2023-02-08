<?php

namespace App\Models;

use App\Models\Response;
use App\Models\SboOfficer;
use App\Models\CampusDirector;
use App\Models\CampusSboAdviser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Endorsement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function campus_sbo_advisers(){

        return $this->belongsToMany(CampusSboAdviser::class, 'campus_sbo_adviser_endorsements' , 'endorsement_id', 'campus_sbo_adviser_id');
    }



    public function response(){
        return $this->belongsTo(Response::class);
    }

    



    

    
}
