<?php

namespace App\Models;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function files(){
        return $this->belongsToMany(File::class, 'school_files', 'school_id', 'file_id');
    }
}
