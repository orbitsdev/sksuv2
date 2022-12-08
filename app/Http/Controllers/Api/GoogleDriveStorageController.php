<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GoogleDriveStorageController extends Controller


{

    
    
    public function fileUpload(Request $request){
        
        
        $files = $request->file('files');
        $filename = $files->getClientOriginalName();
        $filesize = $files->getSize();
        $filepath = $files->getPath();
        

        Storage::disk('public_uploads')->put('uploads/google/'.$filename,  file_get_contents($files));
    
        return response()->json([$filename, $filesize, $filepath], 200);
        

    }

    public function getFiles(Request $request){

        $source = 'uploads/google/1.png';
        $filename = '1.png';
        
         $exist = Storage::disk('public_uploads')->exists($source);
         $content = Storage::disk('public_uploads')->get($source);
         Storage::disk('oss')->put('myfiles/23dd.png', $content, );
         $url = Storage::disk('oss')->url('myfiles/23dd.png');
     

        return response()->json(['success',  $exist, $url ], 200);
    }
}
