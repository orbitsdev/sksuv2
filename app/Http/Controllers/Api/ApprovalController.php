<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\RolesResources;
use App\Models\Response;
use App\Models\ResponseApproval;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalController extends Controller
{
    
    public function approveForm(Request $request){
        
        // $approval = ResponseApproval::where('id', $request->input('approval_id'))->where('response_id', $request->input('response_id'))->update([
        //     'status'=> $request->input('status')
        // ]);
        $approval = ResponseApproval::where('id', $request->input('approval_id'))->where('response_id', $request->input('response_id'))->update([
            'status'=> $request->input('status')
        ]);

        return response()->json([$approval]);

    }   

    public function getAllOfficerApplications(){ 

            $current_adviser_id = auth('sanctum')->user()->id;    
            $current_adviser_role = auth('sanctum')->user()->roles->where('name', 'sbo-adviser')->first();
            $response = Response::whereHas('user', function($query) use($current_adviser_id) {
               $query->whereHas('officer', function($query)use ($current_adviser_id) {
                $query->where('adviser_id', $current_adviser_id);
               }); 
            })->with([
                'user.officer',
                'application_form',
                'response_requirements', 
                'response_requirements.requirement',
                'response_requirements.files',
                'application_form',
                'answers.field',
                'remarks',
                'response_approvals'=> function($query) use ($current_adviser_role){
                    $query->where([
                        ['role_id', $current_adviser_role->id],
                        ['role_name', $current_adviser_role->name]
                    ]);
                }
                
            ])->get();
            // with([
            //     'application_form',
            //     'answers',
            //     'approvals.user.roles', 
            //     'response_requirements', 
            //     'response_requirements.requirement',
            //     'response_requirements.files',

            // ])->get();

            return new ResponseResource($response);

            // return response()->json([$current_adviser_role]);

    }


    public function getApproverRoles(){

        $roles = Role::whereIn('name', ['sbo-adviser','osas','deans','vpaa','campus-director'])->get();

        return new RolesResources($roles);
    }
}
