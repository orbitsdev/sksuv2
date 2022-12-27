<?php

namespace App\Http\Controllers\Api;

use App\Models\School;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;

class DepartmentController extends Controller   
{   

    // public function filter(Request $request){

    //     if($request->input('filter') == 'none'){
    //         return $this->getDepartment();
    //     }else{
    //         $departments =  Department::whereHas('school', function($query) use ($request) {
    //             $query->where('name', $request->input('filter'));
    //     })->with('schools')->paginate(10);
    //     return new DepartmentResource($departments);
    //     }
       
    // }

    public function search(Request $request){

        $departments = Department::where('name', 'like', '%'.$request->input('search').'%')->get();

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
        return new DepartmentResource(Department::paginate(10));
    }

    public function createDepartment(Request $request){
        
        $validated = $request->validate([
            'name' => 'required',
        ],[
            'name' => 'Depertment name is required',
        ]);

        
        Department::create($validated);
        
        return response()->json(['success'], 200);
    }
    
    public function updateDepartment(Request $request){
        
        $validated = $request->validate([
            'name' => 'required',
        ],[
            'name' => 'Depertment name is required',
        ]);


       $department = Department::where('id', $request->input('id'))->first();
       $department->update($validated);

        return response()->json(['success'], 200);
    }


}
