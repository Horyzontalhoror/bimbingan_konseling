<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLetter extends Model
{
    protected $fillable = [
        'student_id',
        'wali_kelas',
        'tanggal',
        'keperluan',
        'file',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
