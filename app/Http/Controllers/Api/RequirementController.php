<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RequirementResource;
use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    
    public function search(Request $request){
        $requirements = Requirement::where('name', 'like', '%'.$request->input('search').'%')->get();

        return new RequirementResource($requirements);
    }
    public function deleteSelectedRequirement(Request $request){
        
        $requirementid = $request->input('requirements_id');
        Requirement::whereIn('id',  $requirementid)->delete();

        return response()->json(['success'], 200);
    
    }

    public function getRequirement(){
       $requirements =  Requirement::paginate(10);
       return new RequirementResource($requirements);

    }

    public function createRequirement(Request $request){
        
       $validated =  $request->validate([
            'name'=> 'required',
            'file_type'=> 'required',
            'upload_type'=> 'required',
        ]);

        Requirement::create($validated);
        return response()->json(['success'], 200);
    }

    public function updateRequirement(Request $request){

        $validated =  $request->validate([
            'name'=> 'required',
            'file_type'=> 'required',
            'upload_type'=> 'required',
        ]);

        $requirement = Requirement::where('id', $request->input('id'))->first();
        $requirement->update($validated);    
        return response()->json([$request->all()], 200);

    }
}
