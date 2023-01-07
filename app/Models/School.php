<?php

namespace App\Models;

use App\Models\File;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function files(){
        return $this->belongsToMany(File::class, 'school_files', 'school_id', 'file_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'school_users', 'school_id', 'user_id');
    }

    public function departments(){
        return $this->belongsToMany(Department::class, 'school_departments', 'school_id', 'department_id');
    }

    
}
