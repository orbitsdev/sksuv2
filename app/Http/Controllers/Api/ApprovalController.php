<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\RolesResources;
use App\Models\Response;
use Illuminate\Http\Request;
use App\Models\Role;

class ApprovalController extends Controller
{
    

    public function getAllOfficerApplications(){ 

            $current_adviser_id = auth('sanctum')->user()->id;     

            $response = Response::whereHas('user', function($query) use($current_adviser_id) {
               $query->whereHas('officer', function($query)use ($current_adviser_id) {
                $query->where('adviser_id', $current_adviser_id);
               }); 
            })->with([
                'application_form',
                'answers',
                'approvals.user.roles', 
                'response_requirements', 
                'response_requirements.requirement',
                'response_requirements.files',

            ])->get();

            return new ResponseResource($response);

    }


    public function getApproverRoles(){

        $roles = Role::whereIn('name', ['sbo-adviser','osas','deans','vpaa','campus-director'])->get();

        return new RolesResources($roles);
    }
}
