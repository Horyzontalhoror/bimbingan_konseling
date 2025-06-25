<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class ParentLogin extends Model
// {
//     //
// }

class ParentLogin extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'nisn'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'nisn', 'nisn');
    }
}
