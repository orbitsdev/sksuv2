<?php

namespace App\Models;

use App\Models\Response;
use App\Models\Requirement;
use App\Models\ResponseRequirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schools(){
        return $this->belongsToMany(School::class , 'school_files', 'file_id', 'school_id');
    }
    public function responses(){
        return $this->belongsToMany(Response::class , 'response_files', 'file_id', 'response_id');
    }

    public function requirements(){
        return $this->belongsToMany(Requirement::class, 'requirement_files', 'file_id', 'requirement_id');
    }
    public function response_requirements(){
        return $this->belongsToMany(ResponseRequirement::class, 'response_requirement_files', 'file_id', 'response_requirement_id');
    }
}
