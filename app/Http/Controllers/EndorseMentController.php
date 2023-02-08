<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\SchoolYear;
use App\Models\Endorsement;
use Illuminate\Http\Request;
use App\Models\CampusSboAdviser;
use App\Http\Resources\SchoolYearResource;

class EndorseMentController extends Controller
{
    
    public function getSchoolYearWithCampusDirector()
    {

        $school_years = SchoolYear::with(['campus_directors.user','campus_directors.school'])->get();
        return new SchoolYearResource($school_years);
        return response()->json([$school_years]);

    }    

    public function endorseResponseToCampusDirector(Request $request){

        
        
        $responses = Response::whereIn('id', $request->input('responses'))->get();
         $auth_id = auth('sanctum')->user()->id;
        $campus_adviser = CampusSboAdviser::where('user_id', $auth_id)->where('school_id', $request->input('school_id'))->first(); 
        $responses = Response::whereIn('id', $request->input('responses'))->get();

        
        foreach($responses as $r){
            $new_endorsement = Endorsement::create([
                'endorser_id'=> $auth_id,
                'response_id'=> $r['id'],
                'reciever_id'=> $request->input('reciever'),
                'status'=> 'pending'
            ]);
            
        }
        
        return response()->json([$responses,$auth_id, $request->all()]);
        $data = [];
        
         

            // $endorsement = Endorsement::create([
            //     'endorser_id'=> auth('sanctum')->user()->id,
            //     'response_id'=> $request->input('response_id'),
            //     'reciver_id'=> $request->input('reciever-id'),
            // ]);






    }

    

 
}
