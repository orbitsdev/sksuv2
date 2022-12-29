<?php

namespace App\Models;

use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Field extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function form(){
        return $this->belongsTo(ApplicationForm::class);
    }
}
