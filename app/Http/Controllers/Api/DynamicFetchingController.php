<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\SchoolResource;
use App\Http\Resources\UserResource;
use App\Models\Department;
use App\Models\School;

class DynamicFetchingController extends Controller
{
    
    public function datatoFetch(Request $request){
        
        $tablename = $request->input('tablename');
        if($tablename == 'users'){
            $users =  User::select('id','first_name', 'last_name')->get();
            return  UserResource::collection($users)->additional([
                'field_id'=>  $request->input('field_id')
            ]);  
        }
        
        if($tablename == 'sbo-adviser'){
            $users =  User::select('id','first_name', 'last_name')->whereHas('roles', function($query){
                $query->where('name', 'sbo-adviser');
            })->get();

            return  UserResource::collection($users)->additional([
                'field_id'=>  $request->input('field_id')
            ]);  
        }
        
        if($tablename == 'sbo'){
            $users =  User::select('id','first_name', 'last_name')->whereHas('roles', function($query){
                $query->where('name', 'sbo');
            })->get();

            return  UserResource::collection($users)->additional([
                'field_id'=>  $request->input('field_id')

            ]);  

        }


        if($tablename == 'departments'){
            $departments =  Department::select('id','name')->get();
            return  DepartmentResource::collection($departments)->additional([
                'field_id'=>  $request->input('field_id')
            ]);  
        }

        if($tablename == 'schools'){
            $schools =  School::select('id','name')->get();

            return  SchoolResource::collection($schools)->additional([
                'field_id'=>  $request->input('field_id')

            ]);

            


        }


    }
}
