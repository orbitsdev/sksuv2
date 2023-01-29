<?php

namespace App\Models;

use App\Models\Field;
use App\Models\Approval;
use App\Models\Response;
use App\Models\Requirement;
use App\Models\ResponseApproval;
use App\Models\ApplicationFormApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationForm extends Model
{
    use HasFactory;
    protected $guarded = [];


    
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    public function requirements()
    {
        return $this->belongsToMany(Requirement::class, 'application_form_requirements', 'application_form_id', 'requirement_id');
    }

    public function departments(){
        return $this->belongsToMany(Department::class, 'school_departments', 'school_id', 'department_id');
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }

    public function approvals(){

        return $this->hasMany(ResponseApproval::class);
        
        // return $this->belongsToMany(Approval::class, 'application_form_approvals', 'application_form_id', 'approval_id');
    }
    
    public function application_form_approvals(){
        return $this->hasMany(ApplicationFormApproval::class);
    }



}
