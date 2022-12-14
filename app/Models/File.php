<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function schools(){
        return $this->belongsToMany(School::class , 'school_files', 'file_id', 'school_id');
    }
}
