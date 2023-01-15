<?php

namespace App\Models;

use App\Models\File;
use App\Models\ApplicationForm;
use App\Models\ResponseRequirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requirement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function applicationForm(){
        return $this->belongsToMany(ApplicationForm::class,'application_form_requirements', 'requirement_id', 'application_form_id');
    }


    public function files(){
        return $this->belongsToMany(File::class, 'requirement_files', 'requirement_id', 'file_id');
    }

    public function responses(){
        return $this->belongsToMany(Response::class, 'requirement_files', 'requirement_id', 'file_id');
    }

    public function response_requirements(){
        return $this->hasMany(ResponseRequirement::class);
    }


}
