<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApplicationForm;
use Illuminate\Http\Request;

class ApplicationFormController extends Controller
{
    

    public function createApplicationForm(Request $request){

        if(count($request->fields) > 0){
            
         $request->validate([
            'title'=> 'required',
            'fields.*.name' => 'required'
        ],
        [
            'name.required' => 'Title is required',
            'fields.*.name' => 'Name is required '
        ]);

        $new_application_form = ApplicationForm::create([
            'title'=> $request->title,
        ]);
        $new_application_form->fields()->createMany($request->fields);

        }else{
          $request->validate([
            'title'=> 'required',

        ],[
            'title.required'=> 'Title is required'
        ]);
        $new_application_form = ApplicationForm::create([
            'title'=> $request->title,
        ]);
        }


       

        return response()->json([$request->only('name'), $request->only('fields'),count($request->fields) ]);

    }
}
