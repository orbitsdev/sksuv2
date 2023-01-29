<?php

namespace App\Models;

use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationFormApproval extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function application_form(){
        return $this->belongsTo(ApplicationForm::class);
    }
}
