<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Answer;
use App\Models\School;
use App\Models\Response;
use App\Models\SchoolYear;
use App\Models\Requirement;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use App\Models\ResponseRequirement;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolYearResource;
use App\Http\Controllers\Api\FileController;
use App\Http\Resources\ApplicationFormResource;
use App\Http\Resources\SchoolResource;

class FillUpApplicationController extends Controller
{



    public function getAuthenticatedSboSchool()
    {

        $auth_id = auth('sanctum')->user()->id;
        $schools = School::whereHas('sbo_offcers', function ($query) use ($auth_id) {
            $query->where('student_id', $auth_id);
        })->with('campus_sbo_advisers.user')->get();



        return new SchoolResource($schools);
    }

    public function getAllSchoolYear()
    {

        $school_years = SchoolYear::whereHas('application_forms')->with('application_forms')->get();

        return new SchoolYearResource($school_years);

        // return response()->json(['succss']);
    }
    public function searchByDate(Request $request)
    {
    }

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

                if (count($requirement['fileToBeRemove']) > 0) {
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

    public function getApplications(Request $request)
    {


        // $applications = ApplicationForm::doesntHave('responses', 'and', function ($query) {
        //     $query->where('user_id', auth('sanctum')->user()->id);
        // })->with('fields', 'requirements')->paginate(10);

        // $applications = ApplicationForm::with('fields', 'requirements')->paginate(10);
        $applications  = ApplicationForm::where('school_year_id', $request->input('school_year_id'))->with(['fields', 'requirements'])->get();
        return new ApplicationFormResource($applications);
    }

    public function getApplcation(Request $request)
    {

        $application = ApplicationForm::select('id', 'title')->where('id', $request->input('application_id'))->with(['fields' => function ($query) {
            $query->orderBy('index', 'asc');
        }, 'requirements' => function ($query) {
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


        $sbo_officer = auth('sanctum')->user()->sbo_officers()->where('school_id',$request->input('school_id'))->first();



        //create response
        $response = $application_form->responses()->create([
            'user_id' => auth('sanctum')->user()->id,
            'school_id'=> $sbo_officer->school_id,
        ]);





        // create adviser aprrover

        if (count($application_form->application_form_approvals) > 0) {

            foreach ($application_form->application_form_approvals as $approval) {
                $response->response_approvals()->create(
                    [
                        'user_id' => null,
                        'role_id' => $approval->role_id,
                        'role_name' => $approval->role_name,
                        'status' => 'null'
                    ]
                );
            }

            // $response->response_approvals()->create([
            //     'user_id'=> null,
            //     'role_name'=> $role->name,
            //     'status'=> 'null'
            // ]);
        }

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
