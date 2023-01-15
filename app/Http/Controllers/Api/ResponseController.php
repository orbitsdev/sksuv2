<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    

    public function createRespose(Request $request){
            
            $request->validate([
                'application_id' => 'required',
                'fields_answer.*.answer',
            ]);


            return response()->json($request->all());

    }
}
