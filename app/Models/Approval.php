<?php

namespace App\Models;

use App\Models\User;
use App\Models\Response;
use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approval extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }

    public function application_form(){
        return $this->belongsTo(ApplicationForm::class);
    }
    // public function application_forms(){
    //     return $this->belongsToMany(ApplicationForm::class , 'application_form_approvals', 'approval_id', 'application_form_id' );
    // }
    
    public function responses(){
        return $this->belongsToMany(Response::class , 'response_approvals', 'approval_id', 'response_id' );
    }
    

}
