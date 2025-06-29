<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonfigurasiKMeansSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_centroid' => 'K1',
                'nilai_centroid' => 0.6,
                'kategori' => 'Butuh Bimbingan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_centroid' => 'K2',
                'nilai_centroid' => 0.7,
                'kategori' => 'Cukup',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_centroid' => 'K3',
                'nilai_centroid' => 0.9,
                'kategori' => 'Baik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('konfigurasi_kmeans')->insert($data);
    }
}
