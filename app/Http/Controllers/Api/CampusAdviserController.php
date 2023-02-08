<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use App\Models\School;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Models\CampusSboAdviser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\SchoolYearResource;
use App\Http\Resources\CampusSboAdviserResource;

class CampusAdviserController extends Controller
{



    public function updateCampusAdviser(Request $request)
    {

        $campus_adviser =  CampusSboAdviser::where('id', $request->input('id'))->update([
            'school_year_id' => $request->input('school_year_id'),
            'user_id' => $request->input('user_id'),
            'school_id' => $request->input('school_id'),
        ]);


        return response()->json(['success']);
    }


    public function search(Request $request)
    {


        $campuse_sbo_advisers  = CampusSboAdviser::when($request->input('search'), function ($query) use ($request) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('first_name', 'like', $request->input('search'))->orWhere('last_name', 'like', '%' . $request->input('search') . '%');
            });
        })->with(['user', 'school', 'school_year'])->get();
        return new CampusSboAdviserResource($campuse_sbo_advisers);
    }

    public function deleteSelectedCampusAdviser(Request $request)
    {

        $campuse_sbo_advisers = CampusSboAdviser::whereIn('id', $request->input('campus_advisers_id'))->with('user')->delete();


        return response()->json(['success',]);
    }

    public function getAllCampusAdvisers()
    {

        $campuse_sbo_advisers  = CampusSboAdviser::with(['user', 'school', 'school_year'])->get();
        return new CampusSboAdviserResource($campuse_sbo_advisers);
    }

    public function addCampusAdviser(Request $request)
    {





        $school_year = SchoolYear::where('id', $request->input('school_year_id'))->first();
        $existing_adviser = $school_year->campus_sbo_advisers()->where('user_id', $request->input('user_id'))->where('school_id', $request->input('school_id'))->first();
        

        $user = User::where('id', $request->input('user_id'))->first();

        $guest =         Role::where('name', 'guest')->first();
        $adviser =         Role::where('name', 'sbo-adviser')->first();




        if ($user->roles()->find($guest->id)) {
            $user->roles()->sync($adviser->id);
        }


        // check if is sbo-adviser withing this a year


        if ($existing_adviser) {



            return response()->json(['success', 'data' => 1]);
        } else {

            $campus_adviser =  CampusSboAdviser::create([
                'school_year_id' => $request->input('school_year_id'),
                'user_id' => $request->input('user_id'),
                'school_id' => $request->input('school_id'),
            ]);

            return response()->json(['success', 'data' => 0]);
        }
    }
    

    public function getAvailableUser()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'osas');
        })->get();
        return new UserResource($users);
    }
}
