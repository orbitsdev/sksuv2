<?php

namespace App\Models;

use App\Models\File;
use App\Models\User;
use App\Models\Answer;

use App\Models\Remark;
use App\Models\School;
use App\Models\Approval;
use App\Models\ApplicationForm;
use App\Models\ResponseApproval;
use App\Models\ResponseRequirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Response extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function application_form(){
        return $this->belongsTo(ApplicationForm::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    // public function files(){
    //     return $this->belongsToMany(File::class, 'response_files', 'response_id', 'file_id');
    // }

    public function response_requirements(){
        return $this->hasMany(ResponseRequirement::class);
    }

    public function approvals(){
        return $this->belongsToMany(Approval::class , 'response_approvals', 'response_id', 'approval_id' );
    }



    public function response_approvals(){
        return $this->hasMany(ResponseApproval::class);
    }

    public function remarks(){
        return $this->hasMany(Remark::class);
    }


    public function school(){
        return $this->belongsTo(School::class);
    }



    

}
