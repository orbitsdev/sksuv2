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
    
    public function deleteAllDepartment(Request $request){
        DB::table('departments')->delete();
        return response()->json(['success'], 200);
    }

    public function deleteSelectedDepartment(Request $request){
        
    Department::whereIn('id', $request->input('deparmentid'))->delete();
    return response()->json(['success'], 200);
    }

    public function getDepartment(Request $request){
        return new DepartmentResource(Department::with('school')->paginate(10));
    }

    public function createDepartment(Request $request){
        
        $validated = $request->validate([
            'name' => 'required',
            'school_id' => 'required'
        ],[
            'name' => 'Depertment name is required',
            'school_id' => 'University is required'
        ]);

        
        Department::create($validated);
        
        return response()->json(['success'], 200);
    }
    
    public function updateDepartment(Request $request){
        
        $validated = $request->validate([
            'name' => 'required',
            'school_id' => 'required'
        ],[
            'name' => 'Depertment name is required',
            'school_id' => 'University is required'
        ]);


       $department = Department::where('id', $request->input('id'))->first();
       $department->update([
        'name'=> $request->input('name'),
        'school_id' => $request->input('school_id'),
       ]);

        return response()->json(['success'], 200);
    }


}
