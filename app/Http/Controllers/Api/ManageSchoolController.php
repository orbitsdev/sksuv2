<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use App\Models\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolResource;
use App\Models\TemporaryStorage;
use Illuminate\Support\Facades\Storage;

class ManageSchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $files =  $request->input('files');

        $school = School::create([
            'name' => $request->name
        ]);

        if (count($files) > 0) {
           $saveFile =  File::create([
                'owned_by' => 'schools',
                'folder' => $files["folder"],
                'file_name' => $files["file_name"],
                'file_type' => $files["file_type"],
            ]);

    
        
            $school->files()->attach($saveFile->id);
           
            $fromTemporaryFolder = 'tmp/' . $saveFile['folder'] . '/' . $saveFile['file_name'];
            $toFilesFolder = 'files/'.$saveFile['owned_by'].'/'. $saveFile['folder'] . '/' . $saveFile['file_name'];
            $temporaryFolderPath ='tmp/'.$saveFile['folder']; 
            
            Storage::disk('public_uploads')->copy($fromTemporaryFolder, $toFilesFolder);
            Storage::disk('public_uploads')->deleteDirectory($temporaryFolderPath);
            TemporaryStorage::where('folder', $saveFile['folder'])->delete();

            return response()->json($files, 200);
        }

        if ($school) {
            return response()->json([$request->all()], 200);
        } else {
            return response()->json(['failed'], 400);
        }
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
