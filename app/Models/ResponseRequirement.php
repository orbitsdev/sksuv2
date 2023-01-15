<?php

namespace App\Models;

use App\Models\File;
use App\Models\Response;
use App\Models\Requirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResponseRequirement extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function response(){
        return $this->belongsTo(Response::class);        
    }


    public function requirement(){
        return $this->belongsTo(Requirement::class);        
    }

    public function files(){
        return $this->belongsToMany(File::class, 'response_requirement_files', 'response_requirement_id', 'file_id');
    }
    

}
