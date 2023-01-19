<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Answer;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use App\Models\ResponseRequirement;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\FileController;
use App\Http\Resources\ApplicationFormResource;
use App\Models\Requirement;

class FillUpApplicationController extends Controller
{


    public function updateResponse(Request $request)
    {
        $request->validate([
            'fields.*.answer_value' => 'required'
        ], [
            'fields.*.answer_value' => 'Field is required'
        ]);


        // update answer

        if (count($request->input('fields')) > 0) {



            $fields = collect($request->input('fields'));
            $fields->groupBy('field_id')->map(function ($answer) {
                return Answer::whereIn('id', $answer->pluck('answer_id'))->update(['answer_value' => $answer->first()['answer_value']]);
            });
        }

        if (count($request->input('requirements')) > 0) {



            foreach ($request->input('requirements') as $requirement) {

                if(count($requirement['fileToBeRemove']) > 0){
                 $response_requirement = ResponseRequirement::where('id', $requirement['response_requirement_id'])->first();
                 FileController::removeFiles($requirement['fileToBeRemove'], 'public_uploads', $response_requirement);

                }

                if (count($requirement['files']) > 0) {
                    $response_requirement = ResponseRequirement::where('id', $requirement['response_requirement_id'])->first();

                    FileController::storeFiles($requirement['files'], 'requirements', 'public_uploads', $response_requirement);
                }
            }

        }




        return response()->json(['success', $request->all()]);
    }

    public function getApplications()
    {


        // $applications = ApplicationForm::doesntHave('responses', 'and', function ($query) {
        //     $query->where('user_id', auth('sanctum')->user()->id);
        // })->with('fields', 'requirements')->paginate(10);
        $applications = ApplicationForm::with('fields', 'requirements')->paginate(10);
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

    public function createResponse(Request $request)
    {

        $request->validate([
            'application_id' => 'required',
            'answers.*.answer' => 'required',
        ], [
            'answers.*.answer' => 'Field is required'

        ]);

        // get application
        $application_form =   ApplicationForm::where('id', $request->input('application_id'))->first();

        //create response
        $response = $application_form->responses()->create([
            'user_id' => auth('sanctum')->user()->id
        ]);


        $adviser = auth('sanctum')->user()->officer->adviser;


        // create adviser aprrover
        $response->approvals()->create([
            'user_id' => $adviser->id,
            'role' => null,
            'decision' => 'processing',

        ]);

        //create answers
        foreach ($request->input('answers') as $answer) {
            $response->answers()->create([
                'field_id' => $answer['field_id'],
                'answer_value' => $answer['answer'],
            ]);
        }


        $c = [];

        // if it has requirements files store to the cloud
        if (count($request->input('requirements')) > 0) {

            foreach ($request->input('requirements') as $requirements) {

                // create response requirements
                $response_requirement = $response->response_requirements()->create([
                    'requirement_id' =>  $requirements['requirement_id']
                ]);

                if (count($requirements['files']) > 0) {

                    FileController::storeFiles($requirements['files'], 'requirements', 'public_uploads', $response_requirement);
                }
            }
        }



        return response()->json(['seuccess', "id" => $response->id]);
        // return response()->json(['seuccess',"id"=> $c]);

    }
}
