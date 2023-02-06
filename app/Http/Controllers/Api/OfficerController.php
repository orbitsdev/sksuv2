<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use App\Models\School;
use App\Models\Department;
use App\Models\SboOfficer;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Models\CampusSboAdviser;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\SchoolResource;
use App\Http\Controllers\OfficerResource;
use App\Http\Resources\DepartmentResource;
use App\Http\Resources\SchoolYearResource;

class OfficerController extends Controller

{

    public function getSchool(Request $request)
    {
    }

    public function getSchoolYearSchool(Request $request)
    {
    
        // $auth_id = auth('sanctum')->user()->id;
        // $school_year = SchoolYear::where('id', $request->input('school_year_id'))->with(['schools.campus_sbo_adviser'=> function($query) use ($auth_id){
        //     $query->where('user_id', $auth_id);
        // }])->first();
        
    
        
        $auth_id = auth('sanctum')->user()->id;
$school_year = SchoolYear::where('id', $request->input('school_year_id'))->first();
$schools = $school_year->schools()->whereHas('campus_sbo_adviser', function($query) use ($auth_id){
$query->where('user_id', $auth_id);
})->get();

return SchoolResource::collection($schools);

        return new SchoolResource($school_year);
    }


    public function getAllSchoolYear()
    {

        $auth_id = auth('sanctum')->user()->id;
        // $school_years =  SchoolYear::whereHas('campus_sbo_advisers', function ($query) use($auth_id) {
        //     $query->whereHas('user', function ($query) use ($auth_id){
        //         $query->where('id', $auth_id);
        //     });
        // })->with(['schools.campus_sbo_adviser'=> function($query) use($auth_id){
        //     $query->where('user_id', $auth_id);    
        // }])->get();

        $school_years = SchoolYear::whereHas('campus_sbo_advisers', function($query) use($auth_id) {
            $query->where('user_id', $auth_id);
        })->with(['schools'=> function($query) use($auth_id){
            $query->whereHas('campus_sbo_advisers', function($query) use($auth_id){ 
                $query->where('user_id', $auth_id);
            });
        }])->get();

        return new SchoolYearResource($school_years);
    }

    public function deleteSelectedOfficer(Request $request)
    {


        // $campus_adviser = CampusSboAdviser::where('user_id', auth('sanctum')->user()->id)->whereHas('school', function ($query) use ($request) {
        //     $query->where('id', $request->input('school_id'));
        // })->with('school')->first();

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

        


        $campus_adviser = CampusSboAdviser::where('user_id', auth('sanctum')->user()->id)->whereHas('school', function ($query) use ($request) {
            $query->where('id', $request->input('school_id'));
        })->with('school')->first();





        $student = User::where('id', $request->input('student_id'))->first();   

        $guest =         Role::where('name', 'guest')->first();
        $sbo =         Role::where('name', 'sbo-student')->first();
        



        if($student->roles()->find($guest->id)){
            $student->roles()->sync($sbo->id);
        }
        
       

        $campus_adviser->sbo_officers()->create($validated);


        return response()->json(['success' , $campus_adviser]);
    }

    public function updateOfficer(Request $request)
    {


            

        $validated = $request->validate([
            'department_id' => 'required',
            'position' => 'required',


        ]);

        

        $campus_adviser = CampusSboAdviser::where('user_id', auth('sanctum')->user()->id)->whereHas('school', function ($query) use ($request) {
            $query->where('id', $request->input('school_id'));
        })->with('school')->first();

        $student = User::where('id', $request->input('student_id'))->first();   

        $guest =         Role::where('name', 'guest')->first();
        $sbo =         Role::where('name', 'sbo-student')->first();
        



        if($student->roles()->find($guest->id)){
            $student->roles()->sync($sbo->id);
        }
        $officer =   $campus_adviser->sbo_officers()->where('id', $request->input('officer_id'))->first();
        $officer->update([
                'department_id' => $request->input('department_id'),
                'position' => $request->input('position'),

        ]);
        // $officer->update([
        //     'adviser_id' => $adviser_id,
        // ]);


        return response()->json(['success']);
    }


    public function getSchoolDepartment()
    {

        $school_id  = auth('sanctum')->user()->schools[0]->id;
        $departments = Department::whereHas('schools', function ($query) use ($school_id) {
            $query->where('schools.id', $school_id);
        })->get();

        return new DepartmentResource($departments);
    }

    public function getStudents(Request $request)
    {   

        $students = User::whereHas('roles', function($query){
                $query->whereIn('roles.name', ['sbo-student','guest']);
        })->whereDoesntHave('sbo_officers')->orWhereHas('sbo_officers.campus_sbo_adviser', function($query)use($request){
            $query->where('school_id', '!=', $request->input('school_id'));
        })->get();

        // $students = User::whereDoesntHave('sbo_officer')
        //         ->orWhereHas('sbo_officer.campus_sbo_adviser.school', function ($query) use ($request) {
        //             $query->where('id', '!=', $request->input('school_id'));
        //         });


        // return response()->json(['scucess', $student]);

        return new UserResource($students);
    }
    public function getOfficers(Request $request)
    {

     




        $officers =  SboOfficer::whereHas('campus_sbo_adviser', function ($query) use ($request) {
            $query->where('user_id', auth('sanctum')->user()->id)->whereHas('school', function ($query) use ($request) {
                $query->where('id', $request->input('school_id'));
            });
        })->with('student', 'department')->get();


   
        return new UserResource($officers);
    }
}
