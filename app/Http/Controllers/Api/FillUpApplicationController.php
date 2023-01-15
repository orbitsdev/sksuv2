<?php

namespace App\Http\Controllers\Api;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\FileController;
use App\Http\Resources\ApplicationFormResource;
use App\Models\Response;
use App\Models\ResponseRequirement;

class FillUpApplicationController extends Controller
{

    public function getApplications(){
        

        $applications = ApplicationForm::doesntHave('responses', 'and', function ($query) {
            $query->where('user_id', auth('sanctum')->user()->id);
        })->with('fields', 'requirements')->paginate(10);
        return new ApplicationFormResource($applications);    
    }

    public function getApplcation(Request $request)
    {

        $application = ApplicationForm::select('id', 'title')->where('id', $request->input('application_id'))->with(['fields', 'requirements' => function ($query) {
            $query->select('requirements.id', 'requirements.name', 'requirements.file_type', 'requirements.upload_type');
        }])->first();

        return new ApplicationFormResource($application);

        //  return response()->json([$request->all()]);
    }

    public function createResponse(Request $request){

        $request->validate([
            'application_id' => 'required',
            'answers.*.answer' => 'required',
        ], [
            'answers.*.answer'=> 'Field is required'
            
        ]);

        // get application
     $application_form =   ApplicationForm::where('id', $request->input('application_id'))->first();

     //create response
       $response = $application_form->responses()->create([
        'user_id'=> auth('sanctum')->user()->id
       ]);


       //create answers

       foreach($request->input('answers') as $answer){

        $response->answers()->create([
        'field_id' => $answer['field_id'],            
        'answer_value' => $answer['answer'],            
        ]);

       }
            

       $c= [];
    if( count($request->input('requirements')) > 0 ){

        foreach($request->input('requirements') as $requirements){

            $response_requirement = $response->response_requirements()->create([
                'requirement_id'=>  $requirements['requirement_id']
            ]);
            
            if(count($requirements['files']) > 0){
               
                FileController::storeFiles($requirements['files'], 'requirements', 'public_uploads', $response);
 
            }
        }
    }       
     


        // return response()->json(['seuccess',"id"=> $response->id]);
        return response()->json(['seuccess',"id"=> $c]);

    }

}
