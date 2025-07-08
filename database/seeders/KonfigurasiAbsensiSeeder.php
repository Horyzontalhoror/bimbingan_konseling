<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonfigurasiAbsensiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('konfigurasi_absensi')->insert([
            ['jenis' => 'A', 'bobot' => 1.0, 'max_jumlah' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['jenis' => 'I', 'bobot' => 0.5, 'max_jumlah' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['jenis' => 'S', 'bobot' => 0.3, 'max_jumlah' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['jenis' => 'B', 'bobot' => 1.2, 'max_jumlah' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
