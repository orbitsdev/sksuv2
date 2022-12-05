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
            $file_name = $image->getClientOriginalName();
            $folder = uniqid() . strtotime(now());
            $file_type =  $image->getClientMimeType();


            if ($image->storeAs('tmp/' . $folder, $file_name, 'public_uploads')) {
                TemporaryStorage::create([
                    'folder' => $folder,
                    'file_name' => $file_name,
                    'file_type' => $file_type,
                ]);
            } else {
                return response()->json('failed to upload', 400);
            }

            return new FilePondResource(['folder' => $folder, 'file_name' => $file_name, 'file_type'=> $file_type]);
        }
        return '';
    }


    public function deleteFromLocalStorage(Request $request)
    {

        $file =  TemporaryStorage::where('folder', $request->input('folder'))->first();
 
        if (Storage::disk('public_uploads')->deleteDirectory('tmp/' . $file->folder)) {
            TemporaryStorage::where('folder', $file->folder)->delete();
            return new FilePondResource(['folder' => $file->folder, 'file_name' => $file->file_name, 'file_type'=> $file->file_type]);
         } else {
            return response()->json(['failed']);
         }
    }
}
