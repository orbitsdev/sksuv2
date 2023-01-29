<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\Field;
use App\Models\Approval;
use App\Models\Requirement;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use App\Http\Controllers\Controller;
use App\Models\ApplicationFormRequirement;
use App\Http\Resources\ApplicationFormResource;
use App\Models\ApplicationFormApproval;

class ApplicationFormController extends Controller
{


    public function search(Request $request){

        $applications = ApplicationForm::where('title', 'like', '%'.$request->input('search').'%')->with(
            ['fields'=> function($query){
               $query->orderBy('index', 'asc');
           } , 
           'requirements' 
       ], )->get();

        return new ApplicationFormResource($applications);
    }

    public function getSingleApplication($id){

        $application = ApplicationForm::where('id', $id)->with(
         ['fields'=> function($query){
            $query->orderBy('index', 'asc');
        } , 
        'requirements' => function($query){
            $query->orderBy('id', 'asc');
        }
    ], )->first();

        return new ApplicationFormResource($application);


    
    }

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
        ApplicationFormApproval::whereIn('application_form_id', $request->input('applicationforms'))->delete();
        return response()->json(['success'], 200);
    }
    public function getApplicationForms()
    {
        $applications  =  ApplicationForm::with('fields', 'requirements','application_form_approvals')->paginate(10);
        return new ApplicationFormResource($applications);
    }


    public function createApplicationForm(Request $request)
    {

        if (count($request->fields) > 0) {

            $request->validate(
                [
                    'title' => 'required',
                    'fields.*.name' => 'required',
                    'fields.*.index' => 'required',
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

        if(count($request->input('approvers')) > 0 ){
           
            $authroize_roles = Role::whereIn('id', $request->input('approvers'))->select('id','name')->get();
            foreach($authroize_roles as $role ){
                
                $new_application_form->application_form_approvals()->create([
                    'user_id'=> null,
                    'role_id'=> $role->id,
                    'role_name'=> $role->name,
                    'status'=> 'null'
                ]);
            }
          
        }


        return response()->json([$request->only('name'), $request->only('fields'), count($request->fields)]);
    }

    public function updateApplicationForm(Request $request){


        if(count($request->fields) > 0){

            $request->validate(
                        [
                            'title' => 'required',
                            'fields.*.name' => 'required',
                            'fields.*.index' => 'required',
                        ],
                        [
                            'name.required' => 'Title is required',
                            'fields.*.name' => 'Name is required '
                        ]
                    );

        // update application 
            $application_form = ApplicationForm::where('id', $request->input('id'))->first();

        
            $application_form->update(
                [
                  'title' => $request->title,
                ]);

            if(count($request->input('approvers'))> 0){
               
                // delete data where noit exist
                $application_form->application_form_approvals()->whereNotIn('role_id',  $request->input('approvers'))->delete();
                $authroize_roles = Role::whereIn('id', $request->input('approvers'))->select('id','name')->get();

                foreach($authroize_roles as $role){                   
                
                    $approval = $application_form->application_form_approvals->where('role_id' , $role->id)->first();
                   
                    if(!$approval){
                        $application_form->application_form_approvals()->create([
                            'user_id'=> null,
                            'role_id'=> $role->id,
                            'role_name'=> $role->name,
                            'status'=> 'null'
                        ]);
                    }
                    
                }

                
            }else{

                if(count( $application_form->application_form_approvals) > 0 ){
                    $application_form->application_form_approvals()->delete();
                }
            }

         // update each fields  of the application
        
            foreach($request->fields  as $field ){

                $pull_field =$application_form->fields()->where('id', $field['id'])->first();
                
                if($pull_field !=  null){
                    $application_form->fields()->where('id', $field['id'])->update(
                        [
                          'name'=> $field['name'],
                          'type'=> $field['type'],
                          'collection_for_select'=> $field['collection_for_select'],
                         ]
                     );
                }else{
                    $n [] = $field;
                    $application_form->fields()->create([
                        'name'=> $field['name'],
                        'type'=> $field['type'],
                        'index'=> $field['index'],
                        'collection_for_select'=> $field['collection_for_select'],
                    ]);
                }
                

            }


        }else{
            // crea new one
            $request->validate(
                [
                    'title' => 'required',
                ],
                [
                    'name.required' => 'Title is required',
                ]
            );

    // update application 
     $application_form = ApplicationForm::where('id', $request->input('id'))->first();
     $application_form->update(['title' => $request->title,]);
   
     // delete if it has field
    if(count($application_form->fields)> 0){
                $application_form->fields()->delete();
            }

    }

    //update requirements
     if (count($request->input('requirements')) > 0) {
            $requirements = Requirement::whereIn('id', $request->input('requirements'))->get()->pluck('id');
            $application_form->requirements()->sync($requirements);
        }else{

            if(count($application_form->requirements)> 0){
                $application_form->requirements()->detach();
            }
        }
        return response()->json(['succsess']);





    }

}
