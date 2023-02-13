<?php

namespace App\Http\Controllers;

use App\Models\Vpa;
use App\Models\Role;
use App\Models\User;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Http\Resources\VpaResource;
use App\Http\Resources\UserResource;

class VpaController extends Controller
{   


    public function getUsers(){
        $users = User::whereHas('roles', function($query) {
            $query->where('name', 'guest');
        })->get();

        return new UserResource($users);
    }
    public function create(Request $request){

        

        $school_year = SchoolYear::where('id', $request->input('school_year_id'))->first();
        $is_user_exist = $school_year->vpas()->where('user_id', $request->input('user_id'))->first();
        $user = User::where('id', $request->input('user_id'))->first();
        $adviser =         Role::where('name', 'vpaa')->first();
        $user->roles()->sync($adviser->id);
        if ($is_user_exist) {   
            return response()->json(['success', 'data' => 1]);
        } else {
            $vpaa  = Vpa::create([
                'user_id'=> $request->input('user_id'),
                'school_year_id' => $request->input('school_year_id'),
            ]);
            return response()->json(['success', 'data' => 0]);
        }
    
       



        return response()->json(['success']);
    }
    
    public function deleteSelected(Request $request){
        
        $vpas = Vpa::whereIn('id', $request->input('vpas'))->get();
        $guest =  Role::where('name', 'guest')->first();

      

        foreach($vpas as $user){
            
            if(count($user->user->vpas) <= 1){
                $user->user->roles()->sync($guest->id);
                
            }
            
        }
         Vpa::whereIn('id', $request->input('vpas'))->delete();
        return response()->json(['success']);
        
    }

    public function getVpa(){


        $vpas = Vpa::with(['user','school_year'])->get();
        // $vpas = Vpa::all();
        
        
        return new VpaResource($vpas);
        // return response()->json(['success' ,$vpas]);
    }

    public function search(Request $request){

        $vpass = Vpa::whereHas('user',  function($query) use($request){
            $query->where('first_name', 'like', '%'.$request->input('search').'%')->orWhere('last_name', 'like', '%'.$request->input('search').'%');
        })->with(['user','school_year'])->get();

        return new VpaResource($vpass);
    }

}
