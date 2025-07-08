<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Violation;

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

    public function violations()
    {
        return $this->hasMany(Violation::class, 'nisn', 'nisn');
    }
}
