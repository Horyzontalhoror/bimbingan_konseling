<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';

    protected $fillable = [
        'name',
        'nisn',
        'class',
        'bindo',
        'bing',
        'mat',
        'ipa',
        'ips',
        'agama',
        'ppkn',
        'sosbud',
        'tik',
        'penjas',
        'jumlah_nilai',
        'rata_rata',
        'kategori',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'nisn', 'nisn');
    }

     // Relasi ke StudentLogin berdasarkan nisn
    public function studentLogin()
    {
        return $this->belongsTo(StudentLogin::class, 'nisn', 'nisn');
    }

}
