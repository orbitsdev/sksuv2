<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseResource;
use App\Models\ApplicationForm;
use App\Models\Response;
use App\Models\ResponseRequirement;
use Illuminate\Http\Request;

class MonitorController extends Controller
{


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

        $responses = Response::when($request->input('search') != null, function ($query)  use ($request) {
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


        return new ResponseResource($responses);
    }

    public function getAllResponse()
    {

        $responses =    Response::where('user_id', auth('sanctum')->user()->id)->with(['application_form' => function ($query) {
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

    public function applicationWithResponse(Request $request)
    {

        $response = Response::where(function ($query) use ($request) {
            $query->where('id', $request->input('id'))->where('user_id', auth('sanctum')->user()->id);
        })->with(['application_form', 'answers.field', 'response_requirements', 'response_requirements.requirement', 'response_requirements.files'])->first();

        return new ResponseResource($response);
    }
}
