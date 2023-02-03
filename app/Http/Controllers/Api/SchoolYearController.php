<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolYearResource;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{


    public function updateSchoolYear(Request $request){
        $school_year = SchoolYear::where('id', $request->input('id'))->first();
        $school_year->update([
            'from' => $request->input('fromYear'),
            'to' => $request->input('toYear'),
        ]);

        return response()->json(['success']);
    }
    public function deleteSelectedSchoolYear(Request $request)
    {

        $school_years =  SchoolYear::whereIn('id', $request->input('school_years'))->get();
        

        foreach($school_years as $sy){

            if(count($sy->schools)> 0 ){
                    $sy->schools()->delete();
            }

        }
     $school_years =  SchoolYear::whereIn('id', $request->input('school_years'))->delete();

        // $school_years->delete();

        return response()->json([$school_years]);
    }

    public function createSchoolYear(Request $request)
    {

        $school_year = SchoolYear::create([
            'from' => $request->input('fromYear'),
            'to' => $request->input('toYear'),
        ]);


        return response()->json(['success']);
    }

    public function getAllSchoolYear()
    {

        $school_years = SchoolYear::all();

        return new SchoolYearResource($school_years);
    }
}
