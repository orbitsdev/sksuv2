<?php

namespace App\Models;

use App\Models\File;
use App\Models\User;
use App\Models\Answer;

use App\Models\ApplicationForm;
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

    public function files(){
        return $this->belongsToMany(File::class, 'response_files', 'response_id', 'file_id');
    }

    public function response_requirements(){
        return $this->hasMany(ResponseRequirement::class);
    }

}
