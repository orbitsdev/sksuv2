<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseResource;
use App\Models\ApplicationForm;
use App\Models\Response;
use Illuminate\Http\Request;

class MonitorController extends Controller
{


    public function getAllResponse(){

        $responses =    Response::where('user_id', auth('sanctum')->user()->id)->with(['application_form' => function($query){
            $query->select('id','title');
        },'answers'=> function($query){
            $query->select('id','response_id','field_id', 'answer_value')->with(['field'=> function($query){
                $query->select('id','name');
            }]);

        }, 'response_requirements'=> function($query){
                $query->select('id', 'response_id', 'requirement_id' )->with(
                    'files');
        },'approvals.user.roles'])->select('id','application_form_id','user_id','created_at')->get();


        return new ResponseResource($responses);
        
    }

    public function applicationWithResponse(Request $request){
 
        $response = Response::where(function($query) use ($request){
            $query->where('id', $request->input('id'))->where('user_id', auth('sanctum')->user()->id) ;
        })->with(['application_form', 'answers.field', 'response_requirements','response_requirements.requirement', 'response_requirements.files' ])->first();

        return new ResponseResource($response);

    }
}
