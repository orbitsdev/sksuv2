<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use Illuminate\Http\Request;
use App\Models\TemporaryStorage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{


    static function storeFiles($files, $owner, $disk, $model)
    {

        foreach ($files  as $file) {

            $createdfile = File::create([
                'owned_by' => $owner,
                'folder' => $file["folder"],
                'file_name' => $file["file_name"],
                'file_type' => $file["file_type"],
            ]);

            $fromTemporaryFolder = 'tmp/' . $createdfile['folder'] . '/' . $createdfile['file_name'];
            $toActualFilesFolder = 'files/' . $createdfile['owned_by'] . '/' . $createdfile['folder'] . '/' . $createdfile['file_name'];
            $temporaryFolderOfFile = 'tmp/' . $createdfile['folder'];

            Storage::disk($disk)->copy($fromTemporaryFolder, $toActualFilesFolder);

            $url  = Storage::disk($disk)->url($toActualFilesFolder);
            $createdfile->update([
                'url' => $url
            ]);

            Storage::disk($disk)->deleteDirectory($temporaryFolderOfFile);
            TemporaryStorage::where('folder', $createdfile['folder'])->delete();
            $model->files()->attach($createdfile->id);
        }
    }

    static function removeFiles($filestoremove, $disk, $model)
    {

        $filecollection = [];

        foreach ($filestoremove as $file) {
            $filecollection[] = $file['id'];
        }

        $databasefile  = File::whereIn('id', $filecollection)->get();

        foreach ($databasefile as $file) {
            $filefolder  = 'files/' . $file['owned_by'] . '/' . $file['folder'];
            Storage::disk($disk)->deleteDirectory($filefolder);
            $model->files()->detach($file['id']);
        }
        File::whereIn('id', $filecollection)->delete();
    }

    static function deleteAttachedFiles($model, $disk)
    {

        foreach ($model->files as $file) {

            File::where('folder', $file['folder'])->delete();
            $filesFolder = 'files/' . $file['owned_by'] . '/' . $file['folder'];
            Storage::disk($disk)->deleteDirectory($filesFolder);
        }


        $model->files()->detach();
    }

    public function deleteTemporaryFiles(Request $request){
        
        $folders = $request->input('folders');
        
        

        
        if(count($folders) > 0){
            foreach($folders as $folder){
                $temporaryFolder = 'tmp/'.$folder;
                Storage::disk('public_uploads')->deleteDirectory($temporaryFolder);
                
            }
            
            TemporaryStorage::whereIn('folder', $folders)->delete();
        }


        return response()->json(['success'], 200);

    }
}
