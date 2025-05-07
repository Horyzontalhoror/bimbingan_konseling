<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    // Tabel yang digunakan
    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }

    protected $fillable = [
        'student_id',
        'date',
        'type',
        'description',
        'action',
    ];

}
