<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JenisPelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('jenis_pelanggaran')->insert([
            [
                'nama' => 'Bolos',
                'poin' => 100,
                'keterangan' => 'Pelanggaran berat: meninggalkan kewajiban tanpa izin.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Berkelahi',
                'poin' => 95,
                'keterangan' => 'Tindakan kekerasan, membahayakan diri/orang lain.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Rambut gondrong/panjang',
                'poin' => 60,
                'keterangan' => 'Melanggar tata tertib penampilan siswa.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Datang terlambat',
                'poin' => 50,
                'keterangan' => 'Mengganggu kedisiplinan waktu sekolah.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Pakaian tidak rapi',
                'poin' => 40,
                'keterangan' => 'Pelanggaran ringan pada penampilan.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Lengan baju dilipat',
                'poin' => 20,
                'keterangan' => 'Pelanggaran ringan – cenderung simbolik ketidakpatuhan.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
