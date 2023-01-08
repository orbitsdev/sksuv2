<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OfficerResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\UserResource;
use App\Models\Department;
use App\Models\SboOfficer;

class OfficerController extends Controller
{
    public function createOfficer(Request $request)
    {

        $validated = $request->validate([
            'student_id' => 'required',
            'department_id' => 'required',
            'position' => 'required',
        ]);


        auth('sanctum')->user()->officers()->create($validated);

        return response()->json(['success'], 200);
    }

    public function updateOfficer(Request $request)
    {


        $validated = $request->validate([
            'student_id' => 'required',
            'department_id' => 'required',
            'position' => 'required',
        ]);


        auth('sanctum')->user()->officers()->update($validated);

        return response()->json(['success'], 200);
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

        $students  = User::select('id', 'first_name', 'last_name')->whereHas('roles', function ($query) {
            $query->where('roles.name', 'sbo-student');
        })->whereDoesntHave('roles', function ($query) {
            $query->where('roles.name', '!=', 'sbo-student');
        })->whereHas('schools', function ($query) use ($school_id) {
            $query->where('schools.id', $school_id);
        })->with('schools')->get();

        return new UserResource($students);
    }
    public function getOfficers()
    {

        $school_id  = auth('sanctum')->user()->schools[0]->id;


        // option1 
        // $officers = SboOfficer::whereHas('adviser.schools', function($query) use($school_id){
        //     $query->where('schools.id', $school_id);
        // })->get();
        $adviser_id  = auth('sanctum')->user()->id;
        $officers = SboOfficer::where('adviser_id', $adviser_id)
            ->whereHas('adviser.schools', function ($query) use ($school_id) {
                $query->where('schools.id', $school_id);
            })->get();




        return new UserResource($officers);
    }
}
