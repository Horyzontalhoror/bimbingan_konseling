<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'nisn',
        'tanggal',
        'hadir',
        'sakit',
        'izin',
        'alpa',
        'bolos',
    ];

    public function siswa()
    {
        return $this->belongsTo(Student::class, 'nisn', 'nisn');
    }
}
