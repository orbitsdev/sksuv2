<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolUser extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'school_users';
   
}
