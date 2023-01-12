<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use App\Models\SboOfficer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Controllers\OfficerResource;
use App\Http\Resources\DepartmentResource;

class OfficerController extends Controller

{

    public function deleteSelectedOfficer(Request $request){

    
            SboOfficer::whereIn('id', $request->input('officers'))->delete();
            return response()->json(['succes',  200]);

    
    }

    public function createOfficer(Request $request)
    {

        $validated = $request->validate([
            'student_id' => 'required',
            'department_id' => 'required',
            'position' => 'required',
        ]);


      

        $student = User::where('id', $request->input('student_id'))->first();  
        $guest_role_id = Role::select('id')->where('name', 'sbo-student')->first();

        if(count($student->roles) > 0){
            foreach($student->roles  as $role){

                if($role->name == "guest"){
                    $student->roles()->sync([$guest_role_id->id]);
                }
            }
        }

        auth('sanctum')->user()->officers()->create($validated);

        return response()->json(['success', $student, $guest_role_id->id], 200);
    }

    public function updateOfficer(Request $request)
    {




        $validated = $request->validate([
            'department_id' => 'required',
            'position' => 'required',


        ]);

    $adviser_id  = auth('sanctum')->user()->id;
    $officer =  SboOfficer::where('id', $request->input('officer_id'))->first();

    $officer->update([
        'adviser_id'=> $adviser_id,
        'department_id' => $request->input('department_id'),
        'position' => $request->input('position'),
    ]);

   
    return response()->json(['success', $request->input('student_id'), $officer, $request->input('student_id')], 200);

    
    }


    public function getSchoolDepartment()
    {

        $school_id  = auth('sanctum')->user()->schools[0]->id;
        $departments = Department::whereHas('schools', function ($query) use ($school_id) {
            $query->where('schools.id', $school_id);
        })->get();

        return new DepartmentResource($departments);
    }

    public function getStudents()
    {

        $school_id  = auth('sanctum')->user()->schools[0]->id;
        $students = User::select('id', 'first_name', 'last_name','email')->whereHas('roles', function($query){
            $query->whereIn('roles.name',['sbo-student','guest']);
        })->whereDoesntHave('officer')->whereHas('schools', function($query) use ($school_id){
            $query->where('schools.id', $school_id);
        })->get();

     
    

        return new UserResource($students);
    }
    public function getOfficers()
    {

        $school_id  = auth('sanctum')->user()->schools[0]->id;
        $adviser_id  = auth('sanctum')->user()->id;

        $officers = SboOfficer::where('adviser_id', $adviser_id)
            ->whereHas('adviser.schools', function ($query) use ($school_id) {
                $query->where('schools.id', $school_id);
            })->with(['student'=> function($query){
                $query->select('id','first_name', 'last_name', );
            },  'department'=> function($query){
                $query->select('id', 'name');
            }])->get();

        return new UserResource($officers);
    }

   
}
