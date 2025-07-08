<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\JenisPelanggaran;

class ViolationSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggaranList = [
            ['2025-01-11', '0099217660', 'Datang terlambat'],
            ['2025-01-13', '0087033132', 'Pakaian tidak rapi'],
            ['2025-01-14', '0086241116', 'Berkelahi'],
            ['2025-01-23', '0086713740', 'Pakaian tidak rapi'],
            ['2025-02-04', '0093320510', 'Rambut gondrong'],
            ['2025-02-07', '0083076105', 'Pakaian tidak rapi'],
            ['2025-02-10', '0081717287', 'Datang terlambat'],
            ['2025-01-10', '0072916601', 'Rambut gondrong'],
            ['2025-01-16', '00109734796', 'Pakaian tidak rapi'],
            ['2025-01-20', '0092385205', 'Rambut panjang'],
            ['2025-01-21', '0091315738', 'Rambut panjang'],
            ['2025-02-05', '0091315738', 'Berkelahi'],
            ['2025-02-06', '0092385205', 'Berkelahi'],
            ['2025-02-07', '0092408141', 'Datang terlambat'],
            ['2025-01-15', '0074781906', 'Berkelahi'],
            ['2025-01-21', '0091560342', 'Pakaian tidak rapi'],
            ['2025-02-03', '0079566743', 'Datang terlambat'],
            ['2025-02-04', '0090440076', 'Berkelahi'],
            ['2025-02-05', '0031752623', 'Pakaian tidak rapi'],
            ['2025-02-05', '00109734796', 'Berkelahi'],
            ['2025-02-06', '0051056398', 'Pakaian tidak rapi'],
            ['2025-01-11', '0012968942', 'Lengan baju dilipat'],
            ['2025-01-13', '0041104552', 'Rambut gondrong'],
            ['2025-01-16', '0041104552', 'Datang terlambat'],
            ['2025-02-03', '0081286174', 'Datang terlambat'],
            ['2025-02-04', '0011171928', 'Berkelahi'],
            ['2025-02-06', '0027791456', 'Datang terlambat'],
        ];

        foreach ($pelanggaranList as [$tanggal, $nisn, $namaPelanggaran]) {
            $student = Student::where('nisn', $nisn)->first();
            $jenis = JenisPelanggaran::where('nama', 'like', "%$namaPelanggaran%")->first();

            if ($student && $jenis) {
                DB::table('violations')->insert([
                    'nisn' => $student->nisn, // ✅ gunakan kolom nisn sesuai struktur
                    'jenis_pelanggaran_id' => $jenis->id,
                    'date' => $tanggal,
                    'type' => $namaPelanggaran, // bisa dihapus jika tidak dipakai
                    'description' => null,
                    'action' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
