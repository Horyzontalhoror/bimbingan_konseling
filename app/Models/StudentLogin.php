<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class StudentLogin extends Authenticatable
{
    protected $fillable = ['nisn', 'password'];

    public function student()
    {
        return $this->hasOne(Student::class, 'nisn', 'nisn');
    }
}

