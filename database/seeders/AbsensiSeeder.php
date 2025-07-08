<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsensiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // kelas A
            ['nisn' => '0104027493', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 2, 'izin' => 3, 'alpa' => 0, 'bolos' => 0],
            ['nisn' => '0109722270', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 3, 'izin' => 4, 'alpa' => 0, 'bolos' => 0],
            ['nisn' => '0094412948', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 1, 'izin' => 4, 'alpa' => 0, 'bolos' => 0],
            ['nisn' => '0104018387', 'tanggal' => now(), 'hadir' => 20, 'sakit' => 0, 'izin' => 2, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0098615925', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 2, 'izin' => 3, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0098392971', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 0, 'izin' => 3, 'alpa' => 4, 'bolos' => 0],
            ['nisn' => '0083076105', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 4, 'izin' => 1, 'alpa' => 0, 'bolos' => 0],
            ['nisn' => '3091012632', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 2, 'izin' => 2, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0091171446', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 2, 'izin' => 5, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0093534490', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 2, 'izin' => 4, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0089692421', 'tanggal' => now(), 'hadir' => 23, 'sakit' => 0, 'izin' => 1, 'alpa' => 0, 'bolos' => 0],
            ['nisn' => '0093464750', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 2, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0086713740', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 2, 'izin' => 1, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0095120213', 'tanggal' => now(), 'hadir' => 15, 'sakit' => 6, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0087561318', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 3, 'izin' => 5, 'alpa' => 0, 'bolos' => 0],
            ['nisn' => '0099217660', 'tanggal' => now(), 'hadir' => 20, 'sakit' => 1, 'izin' => 0, 'alpa' => 2, 'bolos' => 1],
            ['nisn' => '0099217661', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 1, 'izin' => 1, 'alpa' => 4, 'bolos' => 0],
            ['nisn' => '0081495159', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 2, 'izin' => 2, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0093320510', 'tanggal' => now(), 'hadir' => 15, 'sakit' => 4, 'izin' => 2, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0084146110', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 0, 'izin' => 3, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0086241116', 'tanggal' => now(), 'hadir' => 14, 'sakit' => 3, 'izin' => 5, 'alpa' => 1, 'bolos' => 1],
            ['nisn' => '0087033132', 'tanggal' => now(), 'hadir' => 12, 'sakit' => 6, 'izin' => 3, 'alpa' => 2, 'bolos' => 1],
            ['nisn' => '0096517267', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 2, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0084318416', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 1, 'izin' => 3, 'alpa' => 4, 'bolos' => 0],
            ['nisn' => '0086497129', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 2, 'izin' => 3, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0081717287', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 4, 'izin' => 1, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0097740261', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 2, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            // Kelas B
            ['nisn' => '0091011857', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 1, 'izin' => 3, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0074954173', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 1, 'izin' => 4, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0092795157', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 1, 'izin' => 1, 'alpa' => 4, 'bolos' => 0],
            ['nisn' => '0093259561', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 3, 'izin' => 4, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0106893655', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 4, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0092408141', 'tanggal' => now(), 'hadir' => 14, 'sakit' => 3, 'izin' => 4, 'alpa' => 2, 'bolos' => 1],
            ['nisn' => '0072916601', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 1, 'izin' => 0, 'alpa' => 4, 'bolos' => 0],
            ['nisn' => '0086732522', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 3, 'izin' => 2, 'alpa' => 2, 'bolos' => 1],
            ['nisn' => '0088909950', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 5, 'izin' => 1, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0095765435', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 2, 'izin' => 4, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0095568054', 'tanggal' => now(), 'hadir' => 20, 'sakit' => 1, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0091560342', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 4, 'izin' => 2, 'alpa' => 0, 'bolos' => 1],
            ['nisn' => '0109734796', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 3, 'izin' => 1, 'alpa' => 1, 'bolos' => 2],
            ['nisn' => '0103636344', 'tanggal' => now(), 'hadir' => 15, 'sakit' => 3, 'izin' => 4, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0091315738', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 2, 'izin' => 1, 'alpa' => 2, 'bolos' => 2],
            ['nisn' => '0093468540', 'tanggal' => now(), 'hadir' => 20, 'sakit' => 0, 'izin' => 2, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0092385205', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 1, 'izin' => 1, 'alpa' => 2, 'bolos' => 2],
            ['nisn' => '0091904596', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 3, 'izin' => 2, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0089416670', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 0, 'izin' => 2, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0091422639', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 1, 'izin' => 1, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0086819205', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 3, 'izin' => 1, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0096573355', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 3, 'izin' => 2, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0075899766', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 3, 'izin' => 1, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0096593074', 'tanggal' => now(), 'hadir' => 14, 'sakit' => 3, 'izin' => 6, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0084727072', 'tanggal' => now(), 'hadir' => 20, 'sakit' => 2, 'izin' => 1, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0082413528', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 4, 'izin' => 1, 'alpa' => 1, 'bolos' => 0],
            // Kelas C
            ['nisn' => '0010138589', 'tanggal' => now(), 'hadir' => 15, 'sakit' => 2, 'izin' => 4, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0010501924', 'tanggal' => now(), 'hadir' => 13, 'sakit' => 2, 'izin' => 4, 'alpa' => 5, 'bolos' => 0],
            ['nisn' => '0011951127', 'tanggal' => now(), 'hadir' => 21, 'sakit' => 0, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0012890356', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 2, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0014864712', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 1, 'izin' => 2, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0016142138', 'tanggal' => now(), 'hadir' => 21, 'sakit' => 0, 'izin' => 1, 'alpa' => 1, 'bolos' => 1],
            ['nisn' => '0017571235', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 3, 'izin' => 3, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0026204519', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 2, 'izin' => 4, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0029324321', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 2, 'izin' => 2, 'alpa' => 4, 'bolos' => 0],
            ['nisn' => '0030807916', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 3, 'izin' => 2, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0031752623', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 2, 'izin' => 2, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0037133104', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 1, 'izin' => 3, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0051056398', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 3, 'izin' => 1, 'alpa' => 1, 'bolos' => 1],
            ['nisn' => '0057221597', 'tanggal' => now(), 'hadir' => 21, 'sakit' => 1, 'izin' => 1, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0058136002', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 1, 'izin' => 3, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0068924695', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 2, 'izin' => 4, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0069004751', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 2, 'izin' => 2, 'alpa' => 1, 'bolos' => 1],
            ['nisn' => '0071703074', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 1, 'izin' => 2, 'alpa' => 4, 'bolos' => 0],
            ['nisn' => '0074781906', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 0, 'izin' => 1, 'alpa' => 4, 'bolos' => 1],
            ['nisn' => '0076702789', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 2, 'izin' => 3, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0079566743', 'tanggal' => now(), 'hadir' => 14, 'sakit' => 4, 'izin' => 4, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0080012437', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 4, 'izin' => 1, 'alpa' => 0, 'bolos' => 0],
            ['nisn' => '0082433912', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 5, 'izin' => 0, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0083008135', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 3, 'izin' => 2, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0090440076', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 3, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0094161019', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 4, 'izin' => 0, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0095786258', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 0, 'izin' => 3, 'alpa' => 3, 'bolos' => 0],
            // Kelas D
            ['nisn' => '0010137225', 'tanggal' => now(), 'hadir' => 20, 'sakit' => 2, 'izin' => 0, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0011171928', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 2, 'izin' => 3, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0011716173', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 2, 'izin' => 2, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0012968942', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 3, 'izin' => 1, 'alpa' => 2, 'bolos' => 1],
            ['nisn' => '0022137479', 'tanggal' => now(), 'hadir' => 20, 'sakit' => 1, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0027791456', 'tanggal' => now(), 'hadir' => 20, 'sakit' => 1, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0035001248', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 4, 'izin' => 3, 'alpa' => 0, 'bolos' => 0],
            ['nisn' => '0036908994', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 2, 'izin' => 3, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0041104552', 'tanggal' => now(), 'hadir' => 15, 'sakit' => 2, 'izin' => 2, 'alpa' => 4, 'bolos' => 1],
            ['nisn' => '0041742537', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 2, 'izin' => 3, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0044310176', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 1, 'izin' => 2, 'alpa' => 4, 'bolos' => 0],
            ['nisn' => '0046340261', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 2, 'izin' => 2, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0047113495', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 1, 'izin' => 3, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0047525018', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 3, 'izin' => 1, 'alpa' => 4, 'bolos' => 0],
            ['nisn' => '0056274972', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 3, 'izin' => 1, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0059316094', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 2, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0062345651', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 3, 'izin' => 1, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0067307045', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 5, 'izin' => 0, 'alpa' => 2, 'bolos' => 1],
            ['nisn' => '0077751308', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 1, 'izin' => 2, 'alpa' => 4, 'bolos' => 0],
            ['nisn' => '0079439062', 'tanggal' => now(), 'hadir' => 20, 'sakit' => 2, 'izin' => 0, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0081130835', 'tanggal' => now(), 'hadir' => 18, 'sakit' => 3, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0081286174', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 1, 'izin' => 4, 'alpa' => 2, 'bolos' => 0],
            ['nisn' => '0082171856', 'tanggal' => now(), 'hadir' => 16, 'sakit' => 5, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0082344689', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 2, 'izin' => 2, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0082391613', 'tanggal' => now(), 'hadir' => 17, 'sakit' => 2, 'izin' => 2, 'alpa' => 3, 'bolos' => 0],
            ['nisn' => '0087250107', 'tanggal' => now(), 'hadir' => 19, 'sakit' => 1, 'izin' => 3, 'alpa' => 1, 'bolos' => 0],
            ['nisn' => '0089225301', 'tanggal' => now(), 'hadir' => 14, 'sakit' => 4, 'izin' => 3, 'alpa' => 3, 'bolos' => 0],
        ];


        // Tambahkan timestamp ke semua data
        foreach ($data as &$item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
        }

        // Insert ke database
        DB::table('absensi')->insert($data);
    }
}
