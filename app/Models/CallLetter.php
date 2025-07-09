<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLetter extends Model
{
    protected $table = 'call_letters';

    protected $fillable = [
        'student_id',
        'wali_kelas',
        'tanggal',
        'keperluan',
        'file',
        'waktu_pertemuan',
        'tempat_pertemuan',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
