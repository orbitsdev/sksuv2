<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Endorsement;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\CampusDirector;
use App\Models\CampusSboAdviser;
use App\Http\Resources\EndorsementResource;

class CampusDirectorEndorsementController extends Controller
{



        public function getendorsementtFromCampusAdviser(){
                
            $auth_id = auth('sanctum')->user()->id;
            
        $campus_adviser = CampusDirector::where('user_id', $auth_id)->first();
        $endorsements = Endorsement::with([
            
            'response.application_form',
            'response.user.sbo_officer',
                
            'response.response_requirements',
            'response.response_requirements.requirement',
            'response.response_requirements.files',
            'response.answers.field',

            'campus_director.user', 
            'campus_director.school_year', 
            'campus_director.school'])->get();
            
            return new EndorsementResource($endorsements);
            return response()->json([$endorsements]);
    
        
        }


        public function approveform(Request $request){
            
            $endorsement = Endorsement::where('id', $request->input('id'))->first();

            $campus_director_role = Role::where('name', 'campus-director')->first();
         
            if($endorsement->status == 'approved'){
                $endorsement->update([
                    'status'=> 're-evaluating'
                ]);

                
                if( $approval= $endorsement->response->response_approval()->where('role_id', $campus_director_role->id)->first()
                ){
                        $approval->update(['status'=> 're-evaluating']);
                }


                
               
            }else{
                $endorsement->update([
                    'status'=> 'approved'
                ]);
                

                if( $approval= $endorsement->response->response_approval()->where('role_id', $campus_director_role->id)->first()
                ){
                        $approval->update(['status'=> 'approved']);
                }

                
            }
            // $approval = $endorsement->response()->response_approval()->where('role_id', $campus_director_role)->first();
            

            // $notification = Notification::create([

            // ]);
                

            return response()->json(['scuuess',  $campus_director_role, $approval]);
        

        }
        public function returnform(Request $request){
            
            $endorsement = Endorsement::where('id', $request->input('id'))->first();
            $campus_director_role = Role::where('name', 'campus-director')->first();
            $endorsement->update([
                'status'=> 'returned'
            ]);

            if( $approval= $endorsement->response->response_approval()->where('role_id', $campus_director_role->id)->first()
            ){
                    $approval->update(['status'=> 'returned']);
            }


            return response()->json(['scuuess']);
        

        }
}
