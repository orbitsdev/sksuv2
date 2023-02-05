<?php

namespace App\Http\Controllers\Api;

use App\Models\School;
use App\Models\Department;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;

class DepartmentController extends Controller   
{   



    
    

    public function search(Request $request){

        $departments = Department::where('name', 'like', '%'.$request->input('search').'%')->with(['school.school_year'])->get();

        return new DepartmentResource($departments);
    }
    
    public function deleteAllDepartment(Request $request){
        DB::table('departments')->delete();
        return response()->json(['success'], 200);
    }

    public function deleteSelectedDepartment(Request $request){
        
    Department::whereIn('id', $request->input('deparmentid'))->delete();
    return response()->json(['success'], 200);
    }

    public function getDepartment(){
        $departments = Department::with(['school.school_year'])->get();
        return new DepartmentResource($departments);
    }

    public function createDepartment(Request $request){
        
        $validated = $request->validate([
            'name' => 'required',
        ],[
            'name' => 'Depertment name is required',
        ]);
        

        $school_year  = SchoolYear::where('id', $request->input('school_year_id'))->first();
        $school =  $school_year->schools()->where('id', $request->input('school_id'))->first(); 
        $school->deparments()->create([
            'name'=>  $request->input('name')
        ]);  
    

        return response()->json(['success', ], 200);
    }
    
    public function updateDepartment(Request $request){
        
        $validated = $request->validate([
            'name' => 'required',
        ],[
            'name' => 'Depertment name is required',
        ]);


        
     $school_year  = SchoolYear::where('id', $request->input('school_year_id'))->first();
      $school =  $school_year->schools()->where('id', $request->input('school_id'))->first();
      $school->deparments()->where('id' ,$request->input('id'))->update([
        'name'=>  $request->input('name')
      ]); 
    

    

        return response()->json(['success' , $school], 200);
    }


}
