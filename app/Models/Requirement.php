<?php

namespace App\Models;

use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requirement extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function applicationForm(){
        return $this->belongsToMany(ApplicationForm::class,'application_form_requirements', 'requirement_id', 'application_form_id');
    }
}
