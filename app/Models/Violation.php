<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    // Nama tabel secara default adalah 'violations', jadi tidak perlu didefinisikan kecuali berbeda

    protected $fillable = [
        'student_id',
        'jenis_pelanggaran_id', // Ganti dari 'type'
        'date',
        'description',
        'action',
    ];

    // Relasi ke siswa
    public function student()
    {
        return $this->belongsTo(Student::class, 'nisn', 'nisn');
    }


    // Relasi ke jenis pelanggaran
    public function jenis()
    {
        return $this->belongsTo(\App\Models\JenisPelanggaran::class, 'jenis_pelanggaran_id');
    }
}
