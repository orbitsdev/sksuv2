<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\UserResource;
use App\Models\Department;
use App\Models\School;

class DynamicFetchingController extends Controller
{
    
    public function datatoFetch(Request $request){
        
        $tablename = $request->input('tablename');
        if($tablename == 'users'){
            $users =  User::all();
            // return new UserResource($users);  
            return response()->json(['msg'=> 'sucess', 'data'=> $users , 'field_id'=> $request->input('field_id')]);
        }
        
        if($tablename == 'sbo-adviser'){
            $users =  User::whereHas('roles', function($query){
                $query->where('name', 'sbo-adviser');
            })->get();
            // return new UserResource($users);  
            return response()->json(['msg'=> 'sucess', 'data'=> $users , 'field_id'=> $request->input('field_id')]);
        }
        
        if($tablename == 'sbo'){
            $users =  User::whereHas('roles', function($query){
                $query->where('name', 'sbo');
            })->get();

            // return new UserResource($users);  
            return response()->json(['msg'=> 'sucess', 'data'=> $users , 'field_id'=> $request->input('field_id')]);
        }


        if($tablename == 'departments'){
            $departments =  Department::all();
            return response()->json(['msg'=> 'sucess', 'data'=> $departments , 'field_id'=> $request->input('field_id')]);
            // return new DepartmentResource($departments);  
        }

        if($tablename == 'schools'){
            $schools =  School::all();

            // return new UserResource($schools);  
            return response()->json(['msg'=> 'sucess', 'data'=> $schools , 'field_id'=> $request->input('field_id')]);
        }


    }
}
