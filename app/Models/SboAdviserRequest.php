<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SboAdviserRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(){
        $this->belongsTo(User::class);
    }
}
