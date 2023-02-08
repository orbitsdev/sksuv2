<?php

namespace App\Http\Controllers;

use App\Http\Resources\SchoolYearResource;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class EndorseMentController extends Controller
{
    
    public function getSchoolYearWithCampusDirector()
    {

        $school_years = SchoolYear::with(['campus_directors.user','schools'=> function($query) {
            $query->whereHas('campus_directors');
        }])->get();
        return new SchoolYearResource($school_years);

        return response()->json([$school_years]);
    }    

 
}
