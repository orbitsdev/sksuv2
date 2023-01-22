<?php

namespace App\Models;

use App\Models\User;
use Google\Service\Docs\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approval extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function response(){

        return $this->belongsTo(Response::class);

    }

    
    public function user(){
        return $this->belongsTo(User::class)->withDefault();
    }
}