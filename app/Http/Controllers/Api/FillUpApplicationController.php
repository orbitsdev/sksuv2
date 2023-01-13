<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationFormResource;
use App\Models\ApplicationForm;
use Illuminate\Http\Request;

class FillUpApplicationController extends Controller
{

    public function getApplcation(Request $request)
    {


        $application = ApplicationForm::select('id', 'title')->where('id', $request->input('application_id'))->with(['fields', 'requirements' => function ($query) {
            $query->select('requirements.id', 'requirements.name', 'requirements.file_type', 'requirements.upload_type');
        }])->first();



        return new ApplicationFormResource($application);

        //  return response()->json([$request->all()]);
    }
}
