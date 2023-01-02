<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationFormController extends Controller
{
    

    public function createApplicationForm(Request $request){

        $validate = $request->validate([
            'name'=> 'required',
            'fields.*.name' => 'required'
        ]);

    }
}
