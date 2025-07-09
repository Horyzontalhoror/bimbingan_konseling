<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini jika Anda menggunakan factory

class Violation extends Model
{
    use HasFactory; // Tambahkan ini jika Anda menggunakan factory

    // Nama tabel secara default adalah 'violations', jadi tidak perlu didefinisikan kecuali berbeda
    // protected $table = 'violations'; // Opsional, jika nama tabel sesuai konvensi

    protected $fillable = [
        'nisn', // <-- Ganti 'student_id' menjadi 'nisn' di sini!
        'jenis_pelanggaran_id',
        'date',
        'description',
        'action',
    ];

    // Relasi ke siswa
    // Pastikan 'nisn' adalah kolom yang benar di tabel 'violations' dan 'students'
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
