<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingSchedule extends Model
{
    protected $fillable = [
        'student_id',
        'date',
        'time',
        'note',
        'status',
    ];
    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }
}
