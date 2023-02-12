<?php

namespace App\Http\Controllers;

use App\Models\Vpa;
use App\Models\User;
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
        
        $vpaa  = Vpa::create([
            'user_id'=> $request->input('user_id'),
            'school_year_id' => $request->input('school_year_id'),
        ]);

        return response()->json(['success']);
    }
    
    public function deleteSelected(Request $request){
        
        $vpaa = Vpa::whereIn('id', $request->input('vpas'))->delete();
        return response()->json(['success']);
        
    }

    public function getVpa(){
        $vpas = Vpa::all();
        return new VpaResource($vpas);
    }

    public function search(Request $request){

        $vpass = Vpa::whereHas('user',  function($query) use($request){
            $query->where('first_name', 'like', '%'.$request->input('search').'%')->orWhere('last_name', 'like', '%'.$request->input('search').'%');
        })->get();

        return new VpaResource($vpass);
    }

}
