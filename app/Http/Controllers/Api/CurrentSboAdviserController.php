<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrentSboAdviserResource;

class CurrentSboAdviserController extends Controller
{


    public function filter(Request $request){
        if($request->input('filter') == 'none'){
            
            return $this->getCurrentSboAdvisers();
        }else{
            $users = User::whereHas('schools', function($query) use ($request){
                $query->where('name', $request->input('filter'));
            })->whereHas('roles', function($query){
                $query->where('name', 'sbo-adviser');
            })->with('schools')->get();
            return new CurrentSboAdviserResource($users);
        }
       

    }
    
    public function search(Request $request){

      
        $users = User::when($request->input('filter') != 'none',  function($query) use ( $request){
            $query->whereHas('schools', function($query) use($request) {
                $query->where('name', $request->input('filter'));
            } );
        })->whereHas('roles', function($query){
            $query->where('name', 'sbo-adviser');
        })->where(function($query) use ($request){
            $query->where('first_name', 'like', '%'.$request->input('search').'%')->orWhere('last_name', 'like', '%'.$request->input('search').'%')->orWhere('email', 'like', '%'.$request->input('search').'%');
        })->with('schools')->get();
        return new CurrentSboAdviserResource($users);
    }
    public function getCurrentSboAdvisers(){
        
        $users = User::whereHas('roles', function($query){
            $query->where('name', 'sbo-adviser');
        })->with('schools')->paginate(10);
        return new CurrentSboAdviserResource($users);

    }
}
