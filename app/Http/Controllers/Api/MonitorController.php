<?php

namespace App\Http\Controllers\Api;

use App\Models\School;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;
use App\Models\ResponseRequirement;
use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolResource;
use App\Http\Resources\ResponseResource;

class MonitorController extends Controller
{



        public function getSpecificResponse(Request $request){

            $application_response = Response::where('id', $request->input('id'))->with(['application_form','answers.field', 'response_requirements', 'response_requirements.files', 'response_requirements.requirement'])->first();
        
            return new ResponseResource($application_response);
        }
    
    public function getAuthenticatedSboSchool()
    {

        $auth_id = auth('sanctum')->user()->id;
        $schools = School::whereHas('sbo_offcers', function ($query) use ($auth_id) {
            $query->where('student_id', $auth_id);
        })->whereHas('responses', function($query) use ($auth_id){
            $query->where('user_id', $auth_id);
        })->with(['campus_sbo_advisers.user','responses.application_form'])->get();



        return new SchoolResource($schools);
    }
    

    public function deleteSpicificResponse(Request $request)
    {




        $response = Response::where('id', $request->input('id'))->first();

        //delete attached files
        if (count($response->response_requirements) > 0) {
            foreach ($response->response_requirements as $response_requirement) {
                if (count($response_requirement->files) > 0) {
                    FileController::deleteAttachedFiles($response_requirement, 'public_uploads');
                }
            }
            $response->response_requirements->each(function ($responseRequirement) {
                $responseRequirement->files()->detach();
            });
        }
        // delete response_requirement and answers
        $response->response_requirements()->delete();
        $response->answers()->delete();
        $response->response_approvals()->delete();
        // delete response
        $response->delete();

        return response()->json(['success']);
        
    }

    public function searchByDate(Request $request)
    {
        $responses = Response::where('user_id', auth('sanctum')->user()->id)
            ->when($request->input('month'), function ($query, $month) {
                return $query->whereMonth('created_at', $month);
            })
            ->when($request->input('year'), function ($query, $year) {
                return $query->whereYear('created_at', $year);
            })
            ->with(['application_form' => function ($query) {
                $query->select('id', 'title');
            }, 'answers' => function ($query) {
                $query->select('id', 'response_id', 'field_id', 'answer_value')->with(['field' => function ($query) {
                    $query->select('id', 'name');
                }]);
            }, 'response_requirements' => function ($query) {
                $query->select('id', 'response_id', 'requirement_id')->with(
                    'files'
                );
            }, 'approvals.user.roles'])->select('id', 'application_form_id', 'user_id', 'created_at')->get();


        return new ResponseResource($responses);
    }


    public function search(Request $request)
    {

        $responses = Response::when($request->input('search'), function ($query)  use ($request) {
            $query->whereHas('application_form', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search') . '%');
            });
        })->where('user_id', auth('sanctum')->user()->id)->with(['application_form' => function ($query) {
            $query->select('id', 'title');
        }, 'answers' => function ($query) {
            $query->select('id', 'response_id', 'field_id', 'answer_value')->with(['field' => function ($query) {
                $query->select('id', 'name');
            }]);
        }, 'response_requirements' => function ($query) {
            $query->select('id', 'response_id', 'requirement_id')->with(
                'files'
            );
        }, 'approvals.user.roles'])->select('id', 'application_form_id', 'user_id', 'created_at')->get();

        // $response  = Response::when($request->input('search'), function($query->));

        return new ResponseResource($responses);
    }

    public function getAllResponse(Request $request)
    {

        $auth_id = auth('sanctum')->user()->id;



        return response()->json(['sucedasdasdes', $auth_id]);


        // $responses =    Response::where('user_id', auth('sanctum')->user()->id)->with(['application_form' => function ($query) {
        //     $query->select('id', 'title');
        // }, 'answers' => function ($query) {
        //     $query->select('id', 'response_id', 'field_id', 'answer_value')->with(['field' => function ($query) {
        //         $query->select('id', 'name');
        //     }]);
        // }, 'response_requirements' => function ($query) {
        //     $query->select('id', 'response_id', 'requirement_id')->with(
        //         'files'
        //     );
        // },])->select('id', 'application_form_id', 'user_id', 'created_at')->get();
        
        $auth_id = auth('sanctum')->user()->id;

        $responses = Response::where('user_id', $auth_id)
        ->where('school_id', $request->input('school_id'))
        ->with([
            'application_form'
            ])->get();

        return new ResponseResource($responses);
    }

    public function applicationWithResponse(Request $request)
    {

        
        $auth_id = auth('sanctum')->user()->id;

        $application_responses = Response::where('user_id', $auth_id)->with(['application_form','response_approvals.user','school'])->get();

        return new ResponseResource($application_responses);
        return response()->json(['success',$application_responses , $auth_id,  $request->input('school_id')],200);
        // $auth_id = auth('sanctum')->user()->id;

        // $responses  = Response::where('user_id', $auth_id)->where('school_id', $request->input('school_id'))->with(['response_requirements', 'application_form'])->get();
      

        // return new ResponseResource($responses);

    }
}
