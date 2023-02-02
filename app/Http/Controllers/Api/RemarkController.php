<?php

namespace App\Http\Controllers\Api;

use App\Models\Remark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RemarkController extends Controller
{
    
    public function deleteSboRemarkInOfficerDocumentResponse(Request $request){
        $remark =     Remark::where('id', $request->input('remark_id'))->where('response_id', $request->input('response_id'))->delete();

        return response()->json(['success'], 200);
    }
    public function updateSboRemarkInOfficerDocumentResponse(Request $request){
        
        $remark =     Remark::where('id', $request->input('remark_id'))->where('response_id', $request->input('response_id'))->first();
        $remark->update([
            'message'=> $request->input('message')
        ]);

            return response()->json(['success'], 200);

    }
}
