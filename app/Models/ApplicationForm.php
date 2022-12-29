<?php

namespace App\Models;

use App\Models\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationForm extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function fields(){
        return $this->hasMany(Field::class);
    }
}
