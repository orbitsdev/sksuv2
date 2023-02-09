<?php

namespace App\Http\Controllers;

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

            if($endorsement->status == 'approved'){
                $endorsement->update([
                    'status'=> 're-evaluating'
                ]);
                
            }else{
                $endorsement->update([
                    'status'=> 'approved'
                ]);

            }

            // $notification = Notification::create([

            // ]);
            

            return response()->json(['scuuess']);
        

        }
        public function returnform(Request $request){
            
            $endorsement = Endorsement::where('id', $request->input('id'))->first();
            $endorsement->update([
                'status'=> 'returned'
            ]);


            return response()->json(['scuuess']);
        

        }
}
