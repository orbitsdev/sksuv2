<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolFile extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'school_files';
}
