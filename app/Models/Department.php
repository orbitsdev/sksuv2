<?php

namespace App\Models;

use App\Models\School;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function schools(){
        return $this->belongsToMany(School::class, 'school_departments', 'department_id', 'school_id');
    }
}
