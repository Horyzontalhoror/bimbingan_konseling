<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselingSchedule extends Model
{
    protected $fillable = [
        'nisn',
        'date',
        'time',
        'note',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'nisn', 'nisn');
    }
}
