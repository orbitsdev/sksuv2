<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\TemporaryStorage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FilePondResource;

class FilePondController extends Controller
{
    public function uploadToTemporaryStorage(Request $request)
    
    {
    

        if ($request->hasFile('files')) {



            $image = $request->file('files');
            $filename = $image->getClientOriginalName();
            $folder = uniqid() . strtotime(now());
            $filetype =  $image->getClientMimeType();


            if ($image->storeAs('tmp/' . $folder, $filename, 'public_uploads')) {
                TemporaryStorage::create([
                    'folder' => $folder,
                    'filename' => $filename
                ]);
            } else {
                return response()->json('failed to upload', 400);
            }

            return new FilePondResource(['folder' => $folder, 'filename' => $filename, 'type'=> $filetype]);
        }
        return '';
    }


    public function deleteFromLocalStorage(Request $request)
    {

        $file =  TemporaryStorage::where('folder', $request->input('folder'))->first();
 
        if (Storage::disk('public_uploads')->deleteDirectory('tmp/' . $file->folder)) {
            TemporaryStorage::where('folder', $file->folder)->delete();
            return response()->json(['success']);
         } else {
            return response()->json(['failed']);
         }
    }
}
