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





    public function getSchoolDeparment(Request $request)
    {

        $school_department = Department::where('school_id', $request->input('school_id'))->get();

        return new DepartmentResource($school_department);
    }



    public function getSchoolYearSchool(Request $request)
    {

        // $auth_id = auth('sanctum')->user()->id;
        // $school_year = SchoolYear::where('id', $request->input('school_year_id'))->with(['schools.campus_sbo_adviser'=> function($query) use ($auth_id){
        //     $query->where('user_id', $auth_id);
        // }])->first();



        $auth_id = auth('sanctum')->user()->id;
        // $school_year
        $school_year = SchoolYear::where('id', $request->input('school_year_id'))->first();
        $schools = $school_year->schools()->whereHas('campus_sbo_advisers', function ($query) use ($auth_id) {
            $query->where('user_id', $auth_id);
        })->get();

        // $school_year = SchoolYear::where('id', $request->input('school_year_id'))->first();




        return new SchoolResource($schools);
    }


    public function getAllSchoolYear()
    {

        $auth_id = auth('sanctum')->user()->id;

        $school_years = SchoolYear::whereHas('campus_sbo_advisers', function ($query) use ($auth_id) {
            $query->where('user_id', $auth_id);
        })->with(['schools' => function ($query) use ($auth_id) {
            $query->whereHas('campus_sbo_advisers', function ($query) use ($auth_id) {
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




        if ($student->roles()->find($guest->id)) {
            $student->roles()->sync($sbo->id);
        }

        $officer_exist = SboOfficer::where('student_id', $request->input('student_id'))->where('school_id', $request->input('school_id'))->first();

        if ($officer_exist) {
            return response()->json(['success', 'data' => 1]);
        } else {


            $campus_adviser->sbo_officers()->create([
                'student_id' => $request->input('student_id'),
                'department_id' => $request->input('department_id'),
                'school_id' => $request->input('school_id'),
                'position' => $request->input('position'),
            ]);

            return response()->json(['success', 'data' => 0]);
        }
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




        if ($student->roles()->find($guest->id)) {
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

        $students = User::whereHas('roles', function ($query) {
            $query->whereIn('roles.name', ['sbo-student', 'guest']);
        })->whereDoesntHave('sbo_officers')->orWhereHas('sbo_officers.campus_sbo_adviser', function ($query) use ($request) {
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
