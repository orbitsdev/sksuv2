<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use App\Models\User;
use App\Models\School;
use App\Models\Department;
use App\Models\SchoolUser;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Models\SchoolDepartment;
use App\Models\TemporaryStorage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\FileController;

class ManageSchoolController extends Controller
{
    

    public function getSchool(){
        return new SchoolResource(User::all());
    }

    public function attachSchoolToUser (Request $request){
        
        
        $user =   User::where('id', auth('sanctum')->user()->id)->first();
        $selectedSchool = $request->input('school');
        $school = School::where('id', $selectedSchool['id'])->pluck('id')->first();

        if($school != null){
            $user->schools()->sync([$school]);
        }   

        
        return response()->json(['success'], 200);

     }
     
    public function search(Request $request)
    {
        $schools  = School::where('name', 'like', '%' . $request->input('search') . '%')->with('files','departments')->get();
        return new SchoolResource($schools);
    }

    public function deleteSelectedSchool(Request $request)
    {

        $selectedSchoolId = $request->input('selectedSchool');
        $schools = School::whereIn('id', $selectedSchoolId)->get();

        // check if it has schools
        if (count($schools) > 0) {
            // lopp schools
            foreach ($schools as $school) {
                //check if it has files
                if (count($school->files) > 0) {

                    FileController::deleteAttachedFiles($school, 'public_uploads');
                }
            }

            // $user = School::whereIn('id', $selectedSchoolId)->delete();
            $schoolcollection = School::whereIn('id', $selectedSchoolId)->select('id')->get()->pluck('id');
            SchoolUser::whereIn('school_id', $schoolcollection)->delete();
            SchoolDepartment::whereIn('school_id', $schoolcollection)->delete();
            
            School::whereIn('id', $schoolcollection)->delete();
            return response()->json(['success'], 200);
        } else {

            return response()->json(['No Reocord Found '], 400);
        }
    }
    public function deleteAll(Request $request)
    {

        $schools = School::all();

        foreach ($schools as $school) {

            if (count($school->files) > 0) {

                FileController::deleteAttachedFiles($school, 'public_uploads');
            }
        }

        DB::table('schools')->delete();
        DB::table('school_users')->delete();
        DB::table('school_departments')->delete();
      
        return response()->json(['success'], 200);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function index()
    {
        return new SchoolResource(School::with('school_year','files','departments')->paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ],);



        $files = $request->input('files');
        // $organizations = $request->input("organizations");

        $s_year =SchoolYear::where('id', $request->input('school_year'))->first();

    

        $school =$s_year->schools()->create([
            'name' => $request->input('name')
        ]);

        // if(count($organizations)> 0){
        //     $departments = Department::whereIn('id', $organizations)->get()->pluck('id');
        //     $school->departments()->sync($departments);
        // }else{
        //     if(count($school->departments) > 0 ){
        //         $school->departments()->detach();
        //     }
        // }

        if (count($files) > 0) {

            FileController::storeFiles($files, 'schools', 'public_uploads', $school);
        }

        return response()->json(['success',], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, School $school)
    {   

        
        $request->validate([
            'name' => 'required',
        ],);
        $school->update([
            'name' => $request->input('name'),
            'school_year_id' =>$request->input('school_year'),
        ]);

        

        $filetoberemove = $request->input('filetoberemove');
        $filestoadded = $request->input('files');

        $organizations = $request->input("organizations");

        if(count($organizations)> 0){
            $departments = Department::whereIn('id', $organizations)->get()->pluck('id');
            $school->departments()->sync($departments);
        }else{
            if(count($school->departments) > 0 ){
                $school->departments()->detach();
            }
        }



        if (count($filestoadded) > 0) {
            FileController::storeFiles($filestoadded, 'schools', 'public_uploads', $school);
        }

        if (count($filetoberemove) > 0) {
            FileController::removeFiles($filetoberemove, 'public_uploads', $school);
        }

        return response()->json(['success'], 200);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::where('id', $id)->first();

        if (count($school->files) > 0) {

            FileController::deleteAttachedFiles($school, 'public_uploads');
        }
        $school->users()->detach();
        $school->departments()->detach();
        $school->delete();
        return new SchoolResource(['success']);
    }
}
