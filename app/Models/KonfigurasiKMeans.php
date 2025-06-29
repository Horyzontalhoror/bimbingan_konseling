<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfigurasiKMeans extends Model
{
    use HasFactory;

    protected $table = 'konfigurasi_kmeans'; // nama tabel

    protected $fillable = [
        'nama_centroid',
        'nilai_centroid',
        'kategori',
    ];
}
