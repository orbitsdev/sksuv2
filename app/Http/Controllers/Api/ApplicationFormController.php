<?php

namespace App\Http\Controllers\Api;

use App\Models\Field;
use App\Models\Requirement;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use App\Http\Controllers\Controller;
use App\Models\ApplicationFormRequirement;
use App\Http\Resources\ApplicationFormResource;

class ApplicationFormController extends Controller
{

    public function makeApplicationPublic(Request $request)
    {
        $application_form = ApplicationForm::where('id', $request->input('id'))->first();

        $application_form->update([
            'status' => $request->input('status')
        ]);



        return response()->json(['success'], 200);
    }

    public function deleteSelectedApplicationForm(Request $request)
    {
        $forms =  ApplicationForm::whereIn('id', $request->input('applicationforms'))->get();
        foreach ($forms as  $form) {
            if (count($form->fields) > 0) {
                $form->fields()->delete();
            }
            if (count($form->requirements) > 0) {
                $form->requirements()->detach();
            }
        }

        ApplicationForm::whereIn('id', $request->input('applicationforms'))->delete();
        return response()->json(['success'], 200);
    }
    public function getApplicationForms()
    {
        $applications  =  ApplicationForm::with('fields', 'requirements')->paginate(10);
        return new ApplicationFormResource($applications);
    }


    public function createApplicationForm(Request $request)
    {

        if (count($request->fields) > 0) {

            $request->validate(
                [
                    'title' => 'required',
                    'fields.*.name' => 'required'
                ],
                [
                    'name.required' => 'Title is required',
                    'fields.*.name' => 'Name is required '
                ]
            );

            $new_application_form = ApplicationForm::create([
                'title' => $request->title,
            ]);
            $new_application_form->fields()->createMany($request->fields);
        } else {
            $request->validate([
                'title' => 'required',

            ], [
                'title.required' => 'Title is required'
            ]);
            $new_application_form = ApplicationForm::create([
                'title' => $request->title,
            ]);
        }


        if (count($request->input('requirements')) > 0) {
            $requirements = Requirement::whereIn('id', $request->input('requirements'))->get()->pluck('id');
            $new_application_form->requirements()->sync($requirements);
        }


        return response()->json([$request->only('name'), $request->only('fields'), count($request->fields)]);
    }

    public function updateApplicationForm(Request $request){
        


        if (count($request->fields) > 0) {

            $request->validate(
                [
                    'title' => 'required',
                    'fields.*.name' => 'required'
                ],
                [
                    'name.required' => 'Title is required',
                    'fields.*.name' => 'Name is required '
                ]
            );

            $application_form = ApplicationForm::where('id', $request->input('id'))->first();
            $application_form->update([
                'title' => $request->title,
            ]);
            $application_form->fields()->delete();
            $application_form->fields()->createMany($request->fields);
        } else {


            $request->validate([
                'title' => 'required',

            ], [
                'title.required' => 'Title is required'
            ]);


            $application_form = ApplicationForm::where('id', $request->input('id'))->first();
            $application_form->update([
                'title' => $request->title,
            ]);

            if(count($application_form->fields)> 0){
                $application_form->fields()->delete();
            }
        }


        if (count($request->input('requirements')) > 0) {
            $requirements = Requirement::whereIn('id', $request->input('requirements'))->get()->pluck('id');
            $application_form->requirements()->sync($requirements);
        }else{

            if(count($application_form->requirements)> 0){
                $application_form->requirements()->detach();
            }
        }


        return response()->json([$request->only('name'), $request->only('fields'), count($request->fields)]);

    }

}
