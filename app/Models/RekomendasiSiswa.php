<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekomendasiSiswa extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi_siswa';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['nisn', 'kategori', 'metode', 'sumber', 'keterangan'];

    public static function getByNisn($nisn)
    {
        return self::where('nisn', $nisn)->first();
    }
}
