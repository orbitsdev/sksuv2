<?php

namespace App\Http\Controllers;

use App\Http\Resources\CampusDirectorResource;
use App\Models\CampusDirector;
use App\Models\Role;
use App\Models\User;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class CampusDirectorController extends Controller
{


    public function create(Request $request)
    {


        $school_year = SchoolYear::where('id', $request->input('school_year_id'))->first();
        $is_user_exist = $school_year->campus_directors()->where('user_id', $request->input('user_id'))->where('school_id', $request->input('school_id'))->first();
        $user = User::where('id', $request->input('user_id'))->first();
        $guest =         Role::where('name', 'guest')->first();
        
        $adviser =         Role::where('name', 'campus-director')->first();

        $user->roles()->sync($adviser->id);
       
        if ($is_user_exist) {
            return response()->json(['success', 'data' => 1]);
        } else {
            $campi_direcotr =  CampusDirector::create([
                'school_year_id' => $request->input('school_year_id'),
                'user_id' => $request->input('user_id'),
                'school_id' => $request->input('school_id'),
            ]);
            return response()->json(['success', 'data' => 0]);
        }

    }


    public function deleteSelected(Request $request)
    {

        $campus_directors = CampusDirector::whereIn('id', $request->input('campus_directors_id'))->with('user')->get();

            
        $guest =  Role::where('name', 'guest')->first();

      

        foreach($campus_directors as $adviser){
            
            if(count($adviser->user->campus_directors) <= 1){
                $adviser->user->roles()->sync($guest->id);
                
            }
            
        }
        
      CampusDirector::whereIn('id', $request->input('campus_directors_id'))->with('user')->delete();
        return response()->json(['success',]);
    }




    public function getAllCampusDirectors()
    {

        $campus_directors  = CampusDirector::with(['user', 'school', 'school_year'])->get();
        return new CampusDirectorResource($campus_directors);
    }



}
