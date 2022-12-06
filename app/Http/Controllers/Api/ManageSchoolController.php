<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use App\Models\School;
use Illuminate\Http\Request;
use App\Models\TemporaryStorage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolResource;
use Illuminate\Support\Facades\Storage;

class ManageSchoolController extends Controller
{

    public function search(Request $request)
    {
        $schools  = School::where('name', 'like', '%' . $request->input('search') . '%')->with('files')->get();
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
                    // loop files
                    foreach ($school->files as $file) {
                        // delete database
                        File::where('folder', $file->folder)->delete();
                        $fileFolder = 'files/' . $file->owned_by . '/' . $file->folder;
                        Storage::disk('public_uploads')->deleteDirectory($fileFolder);
                    }
                    $school->files()->detach();
                }
            }

            School::whereIn('id', $selectedSchoolId)->delete();
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


                foreach ($school->files as $file) {

                    File::where('folder', $file['folder'])->delete();
                    $filesFolder = 'files/' . $file['owned_by'] . '/' . $file['folder'];
                    Storage::disk('public_uploads')->deleteDirectory($filesFolder);
                }


                $school->files()->detach();
            }
        }

        if (DB::table('schools')->delete()) {
            return response()->json(['success'], 200);
        } else {
            return response()->json(['failed'], 400);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new SchoolResource(School::with('files')->paginate(20));
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
        ]);

        $files = $request->input('files');

        $school = School::create([
            'name'=> $request->input('name')
        ]);


        if (count($files) > 0) {

            $filesId = [];

            foreach ($files  as $file) {
                
                $createdfile = File::create([
                    'owned_by' => 'schools',
                    'folder' => $file["folder"],
                    'file_name' => $file["file_name"],
                    'file_type' => $file["file_type"],
                ]);

                $fromTemporaryFolder = 'tmp/' . $createdfile['folder'] . '/' . $createdfile['file_name'];
                $toFilesFolder = 'files/' . $createdfile['owned_by'] . '/' . $createdfile['folder'] . '/' . $createdfile['file_name'];
                $temporaryFolderPath = 'tmp/' . $createdfile['folder'];
                Storage::disk('public_uploads')->copy($fromTemporaryFolder, $toFilesFolder);
                Storage::disk('public_uploads')->deleteDirectory($temporaryFolderPath);
                $fileId[] = $createdfile->id;
            }

            if(count($fileId) > 0){
                $school->files()->sync($fileId);
            }
            
        }

        return response()->json(['success', $fileId], 200);
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

    public function inserNewFile($files)
    {
        foreach ($files as $file) {
            // INSERT NEW FILES 
            if (File::where('folder', $file['folder'])->doesntExist()) {
                $newFIle = File::create([
                    'owned_by' => 'schools',
                    'folder' => $files["folder"],
                    'file_name' => $files["file_name"],
                    'file_type' => $files["file_type"],
                ]);

                $fromTemporaryFolder = 'tmp/' . $newFIle['folder'] . '/' . $newFIle['file_name'];
                $toFilesFolder = 'files/' . $newFIle['owned_by'] . '/' . $newFIle['folder'] . '/' . $newFIle['file_name'];
                $temporaryFolderPath = 'tmp/' . $newFIle['folder'];
                Storage::disk('public_uploads')->copy($fromTemporaryFolder, $toFilesFolder);
                Storage::disk('public_uploads')->deleteDirectory($temporaryFolderPath);
                TemporaryStorage::where('folder', $newFIle['folder'])->delete();
            }
        }
    }

    public function removeDatabaseFile(School $school)
    {

        // Check if ha data

        if (count($school->files) > 0) {
            $folders = [];
            foreach ($school->files as $file) {
                $folders[] = $file['folder'];
                $fileFolder = '/files' . '/' . $file['owned_by'] . '/' . $file['folder'];
                Storage::disk('public_uploads')->deleteDirectory($fileFolder);
            }
            File::whereIn('folder', $folders)->delete();
            $school->files()->detach();
        }
    }

    public function update(Request $request, School $school)

    {
        $request->validate([
            'name' => 'required'
        ]);

        $school->update([
            'name'=> $request->input('name')
        ]);
            
        $schoolfiles = $request->input('files');        


        if(count($schoolfiles) > 0){
            $createdfileid  = [];
            foreach($schoolfiles as $file){
               $createdfile =  File::create([
                    'owned_by' => 'schools',
                    'folder' => $file["folder"],
                    'file_name' => $file["file_name"],
                    'file_type' => $file["file_type"],
                ]);

                $createdfileid[] = $createdfile['id'];
                $fromtemporaryfolder = 'tmp/'.$createdfile['folder'].'/'.$createdfile['file_name'];
                $tofilefolder = 'files/'.$createdfile['owned_by'].'/'.$createdfile['folder'].'/'.$createdfile['file_name'];
                $tempFolder = 'tmp/'.$createdfile['folder'];
                Storage::disk('public_uploads')->copy($fromtemporaryfolder, $tofilefolder);
                Storage::disk('public_uploads')->deleteDirectory($tempFolder);
                
                
            }
            $school->files()->sync($createdfileid);

        }



        return response()->json([$createdfileid, $school->files], 200);
        
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

            foreach ($school->files as $file) {
                File::where('folder', $file->folder)->delete();
                Storage::disk('public_uploads')->deleteDirectory('files/' . $file->owned_by . '/' . $file->folder);
            }

            $school->files()->detach();
        }

        $school->delete();

        return new SchoolResource(['success']);
    }
}
