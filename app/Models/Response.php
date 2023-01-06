<?php

namespace App\Models;

use App\Models\Answer;
use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Response extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function application(){
        return $this->belongsTo(ApplicationForm::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }


}
