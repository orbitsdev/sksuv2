<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampusDeanResouce;
use App\Models\Role;
use App\Models\User;
use App\Models\CampusDean;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class CampusDeanController extends Controller
{


    
    public function create(Request $request)
    {


        $school_year = SchoolYear::where('id', $request->input('school_year_id'))->first();
        $is_user_exist = $school_year->campus_deans()->where('user_id', $request->input('user_id'))->where('school_id', $request->input('school_id'))->first();
        $user = User::where('id', $request->input('user_id'))->first();
        $guest =         Role::where('name', 'guest')->first();
        $dean =         Role::where('name', 'campus-director')->first();

        $user->roles()->sync($dean->id);
       
        if ($is_user_exist) {
            return response()->json(['success', 'data' => 1]);
        } else {
            $campi_direcotr =  CampusDean::create([
                'school_year_id' => $request->input('school_year_id'),
                'user_id' => $request->input('user_id'),
                'school_id' => $request->input('school_id'),
            ]);
            return response()->json(['success', 'data' => 0]);
        }

    }


    public function deleteSelected(Request $request)
    {

        $campus_directors = CampusDean::whereIn('id', $request->input('campus_deans_id'))->with('user')->delete();
        return response()->json(['success',]);
    }




    public function getAllCampusDirectors()
    {

        $campus_deans  = CampusDean::with(['user', 'school', 'school_year'])->get();
        return new CampusDeanResouce($campus_deans);
    }

    //
}
