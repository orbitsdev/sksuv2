<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\School;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Models\ResponseApproval;
use App\Http\Controllers\Controller;
use App\Http\Resources\RolesResources;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\SchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalController extends Controller
{
    


    public function getSchools(){
    

        $auth_id = auth('sanctum')->user()->id;
        // return response()->json(['success', $auth_id ]);
        $schools  = School::whereHas('campus_sbo_advisers', function($query) use($auth_id){
            $query->where('user_id', $auth_id );
        })->whereHas('responses')->with('responses')->get();

        return new SchoolResource($schools);
        
    }

    public function returnForm(Request $request){



        $response_approval = ResponseApproval::where('id', $request->input('approval_id'))->where('response_id', $request->input('response_id'))->first();
    
        $response_approval->update([
            'user_id'=> auth('sanctum')->user()->id,
            'status'=> $request->input('status')
        ]);

    
        $remark = $response_approval->response->remarks()->create([
            'user_id'=> auth('sanctum')->user()->id,
            'message'=> $request->input('remark')
        ]);
        
   
        $message = auth('sanctum')->user()->first_name .' '.auth('sanctum')->user()->last_name.' Added Remarks to  '. $response_approval->response->application_form->tile. ' Appplication ';

      $notification =   $response_approval->response->user->notifications()->create([
            'recipient_id'=>      $response_approval->response->user->id,
            'type'=> 'Applications',
            'content'=>  $message
        ]);

   

        return response()->json([$remark ]);
        

    }
    public function approveForm(Request $request){
       

        
        $approval = ResponseApproval::where('id', $request->input('approval_id'))->where('response_id', $request->input('response_id'))->first();
        
        $approval->update([
            'user_id'=> auth('sanctum')->user()->id,
            'status'=> $request->input('status')
        ]);
        
        $message = auth('sanctum')->user()->first_name .' '.auth('sanctum')->user()->last_name.' '.$request->input('status'). 'Your '. $approval->response->application_form->tile. ' Appplication ';
        $approval->response->user->notifications()->create([
            'recipient_id'=>      $approval->response->user->id,
            'type'=> 'Applications',
            'content'=>  $message
        ]);


        

        return response()->json([$approval]);

    }   

    public function getAllOfficerApplications(Request $request){ 

        
        $auth_id = auth('sanctum')->user()->id;    
        $current_adviser_role = auth('sanctum')->user()->roles->where('name', 'sbo-adviser')->first();

           $responses = Response::whereDoesntHave('endorsement')->where('school_id', $request->input('school_id'))->with([
            'user.sbo_officer'=> function($query) use($request) {
                $query->where('school_id', $request->input('school_id'));
            },
            'user.sbo_officers',
            'application_form',
            'response_requirements',
            'response_requirements.requirement',
            'response_requirements.files',
            'answers.field',
            'remarks',
            'endorsement'=>function($query) use($auth_id){
                $query->where('endorser_id', $auth_id);
            },
            'response_approval' => function($query) use ($current_adviser_role){
                $query->where([
                    ['role_id', $current_adviser_role->id],
                    ['role_name', $current_adviser_role->name]
                ]);
            },
            'response_approvals'
           ])->get();

           return new ResponseResource($responses);

        
          

            

    }


    public function getApproverRoles(){

        $roles = Role::whereIn('name', ['sbo-adviser','osas','deans','vpaa','campus-director'])->get();

        return new RolesResources($roles);
    }
}
