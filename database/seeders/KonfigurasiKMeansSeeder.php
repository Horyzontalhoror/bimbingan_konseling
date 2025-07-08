<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KonfigurasiKMeansSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('konfigurasi_kmeans')->insert([
            // --- KMeans Nilai ---
            [
                'nama_centroid' => 'K1',
                'tipe' => 'nilai',
                'centroid' => 0.60,
                'kategori' => 'Butuh Bimbingan',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_centroid' => 'K2',
                'tipe' => 'nilai',
                'centroid' => 0.70,
                'kategori' => 'Cukup',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_centroid' => 'K3',
                'tipe' => 'nilai',
                'centroid' => 0.90,
                'kategori' => 'Baik',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // --- KMeans Absen ---
            [
                'nama_centroid' => 'K1',
                'tipe' => 'absen',
                'centroid' => 1.00,
                'kategori' => 'Sering Absen',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_centroid' => 'K2',
                'tipe' => 'absen',
                'centroid' => 0.50,
                'kategori' => 'Cukup',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_centroid' => 'K3',
                'tipe' => 'absen',
                'centroid' => 0.00,
                'kategori' => 'Rajin',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // --- KMeans Pelanggaran ---
            [
                'nama_centroid' => 'K1',
                'tipe' => 'pelanggaran',
                'centroid' => 1.00,
                'kategori' => 'Sering',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_centroid' => 'K2',
                'tipe' => 'pelanggaran',
                'centroid' => 0.50,
                'kategori' => 'Ringan',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_centroid' => 'K3',
                'tipe' => 'pelanggaran',
                'centroid' => 0.00,
                'kategori' => 'Tidak Pernah',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
