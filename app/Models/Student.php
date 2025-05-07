<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'nisn',
        'class',
        'gender',
        'address',
        'birth_date',
    ];
}
