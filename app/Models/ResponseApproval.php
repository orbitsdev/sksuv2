<?php

namespace App\Models;

use App\Models\Response;
use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResponseApproval extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function response(){
        return $this->belongsTo(Response::class);
    }
}
