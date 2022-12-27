<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolDepartment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'school_departments';
}
