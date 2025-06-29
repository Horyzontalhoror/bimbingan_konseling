<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nisn' => '0104027493', 'bindo' => 76, 'bing' => 71, 'mat' => 70, 'ipa' => 77, 'ips' => 79, 'agama' => 78, 'ppkn' => 73, 'sosbud' => 82, 'tik' => 80, 'penjas' => 75],
            ['nisn' => '0109722270', 'bindo' => 75, 'bing' => 73, 'mat' => 76, 'ipa' => 85, 'ips' => 81, 'agama' => 87, 'ppkn' => 73, 'sosbud' => 85, 'tik' => 82, 'penjas' => 81],
            ['nisn' => '0094412948', 'bindo' => 72, 'bing' => 78, 'mat' => 69, 'ipa' => 77, 'ips' => 76, 'agama' => 77, 'ppkn' => 74, 'sosbud' => 78, 'tik' => 77, 'penjas' => 75],
            ['nisn' => '0104018387', 'bindo' => 72, 'bing' => 72, 'mat' => 73, 'ipa' => 79, 'ips' => 79, 'agama' => 80, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 80, 'penjas' => 76],
            ['nisn' => '0098615925', 'bindo' => 77, 'bing' => 77, 'mat' => 73, 'ipa' => 85, 'ips' => 80, 'agama' => 88, 'ppkn' => 82, 'sosbud' => 82, 'tik' => 80, 'penjas' => 83],
            ['nisn' => '0098392971', 'bindo' => 72, 'bing' => 70, 'mat' => 69, 'ipa' => 77, 'ips' => 80, 'agama' => 79, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 77, 'penjas' => 77],
            ['nisn' => '0083076105', 'bindo' => 74, 'bing' => 74, 'mat' => 75, 'ipa' => 83, 'ips' => 80, 'agama' => 76, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 79, 'penjas' => 74],
            ['nisn' => '3091012632', 'bindo' => 89, 'bing' => 75, 'mat' => 77, 'ipa' => 85, 'ips' => 84, 'agama' => 89, 'ppkn' => 75, 'sosbud' => 78, 'tik' => 82, 'penjas' => 84],
            ['nisn' => '0091171446', 'bindo' => 72, 'bing' => 70, 'mat' => 70, 'ipa' => 80, 'ips' => 80, 'agama' => 84, 'ppkn' => 73, 'sosbud' => 78, 'tik' => 78, 'penjas' => 75],
            ['nisn' => '0093534490', 'bindo' => 73, 'bing' => 73, 'mat' => 71, 'ipa' => 83, 'ips' => 80, 'agama' => 76, 'ppkn' => 76, 'sosbud' => 80, 'tik' => 78, 'penjas' => 79],
            ['nisn' => '0089692421', 'bindo' => 73, 'bing' => 71, 'mat' => 76, 'ipa' => 83, 'ips' => 80, 'agama' => 76, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 80, 'penjas' => 78],
            ['nisn' => '0093464750', 'bindo' => 72, 'bing' => 71, 'mat' => 72, 'ipa' => 77, 'ips' => 81, 'agama' => 76, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 78, 'penjas' => 76],
            ['nisn' => '0086713740', 'bindo' => 73, 'bing' => 73, 'mat' => 38, 'ipa' => 0,  'ips' => 0,  'agama' => 0,  'ppkn' => 0,  'sosbud' => 75, 'tik' => 0,  'penjas' => 0],
            ['nisn' => '0095120213', 'bindo' => 75, 'bing' => 75, 'mat' => 72, 'ipa' => 85, 'ips' => 81, 'agama' => 89, 'ppkn' => 74, 'sosbud' => 84, 'tik' => 80, 'penjas' => 83],
            ['nisn' => '0087561318', 'bindo' => 76, 'bing' => 69, 'mat' => 73, 'ipa' => 87, 'ips' => 79, 'agama' => 82, 'ppkn' => 73, 'sosbud' => 85, 'tik' => 80, 'penjas' => 76],
            ['nisn' => '0099217660', 'bindo' => 71, 'bing' => 71, 'mat' => 67, 'ipa' => 75, 'ips' => 78, 'agama' => 74, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 79, 'penjas' => 74],
            ['nisn' => '0099217661', 'bindo' => 75, 'bing' => 71, 'mat' => 71, 'ipa' => 84, 'ips' => 79, 'agama' => 89, 'ppkn' => 73, 'sosbud' => 82, 'tik' => 80, 'penjas' => 76],
            ['nisn' => '0081495159', 'bindo' => 76, 'bing' => 70, 'mat' => 76, 'ipa' => 82, 'ips' => 81, 'agama' => 75, 'ppkn' => 77, 'sosbud' => 80, 'tik' => 78, 'penjas' => 79],
            ['nisn' => '0093320510', 'bindo' => 72, 'bing' => 71, 'mat' => 73, 'ipa' => 75, 'ips' => 81, 'agama' => 75, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 76, 'penjas' => 77],
            ['nisn' => '0084146110', 'bindo' => 72, 'bing' => 70, 'mat' => 71, 'ipa' => 76, 'ips' => 81, 'agama' => 76, 'ppkn' => 73, 'sosbud' => 82, 'tik' => 77, 'penjas' => 75],
            ['nisn' => '0086241116', 'bindo' => 73, 'bing' => 70, 'mat' => 76, 'ipa' => 76, 'ips' => 77, 'agama' => 75, 'ppkn' => 73, 'sosbud' => 75, 'tik' => 78, 'penjas' => 74],
            ['nisn' => '0087033132', 'bindo' => 72, 'bing' => 74, 'mat' => 73, 'ipa' => 76, 'ips' => 74, 'agama' => 75, 'ppkn' => 73, 'sosbud' => 79, 'tik' => 76, 'penjas' => 75],
            ['nisn' => '0096517267', 'bindo' => 78, 'bing' => 70, 'mat' => 75, 'ipa' => 85, 'ips' => 77, 'agama' => 90, 'ppkn' => 73, 'sosbud' => 85, 'tik' => 79, 'penjas' => 80],
            ['nisn' => '0084318416', 'bindo' => 71, 'bing' => 70, 'mat' => 74, 'ipa' => 77, 'ips' => 79, 'agama' => 76, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 77, 'penjas' => 77],
            ['nisn' => '0086497129', 'bindo' => 71, 'bing' => 71, 'mat' => 73, 'ipa' => 76, 'ips' => 81, 'agama' => 82, 'ppkn' => 80, 'sosbud' => 81, 'tik' => 76, 'penjas' => 77],
            ['nisn' => '0081717287', 'bindo' => 71, 'bing' => 70, 'mat' => 70, 'ipa' => 76, 'ips' => 80, 'agama' => 76, 'ppkn' => 73, 'sosbud' => 79, 'tik' => 80, 'penjas' => 75],
            ['nisn' => '0097740261', 'bindo' => 71, 'bing' => 70, 'mat' => 73, 'ipa' => 75, 'ips' => 74, 'agama' => 74, 'ppkn' => 73, 'sosbud' => 72, 'tik' => 75, 'penjas' => 75],
            ['nisn' => '0091011857', 'bindo' => 78, 'bing' => 74, 'mat' => 76, 'ipa' => 87, 'ips' => 79, 'agama' => 85, 'ppkn' => 73, 'sosbud' => 79, 'tik' => 77, 'penjas' => 78],
            ['nisn' => '0074954173', 'bindo' => 73, 'bing' => 62, 'mat' => 75, 'ipa' => 75, 'ips' => 75, 'agama' => 75, 'ppkn' => 73, 'sosbud' => 73, 'tik' => 73, 'penjas' => 74],
            ['nisn' => '0092795157', 'bindo' => 73, 'bing' => 70, 'mat' => 70, 'ipa' => 75, 'ips' => 79, 'agama' => 75, 'ppkn' => 73, 'sosbud' => 78, 'tik' => 75, 'penjas' => 75],
            ['nisn' => '0093259561', 'bindo' => 77, 'bing' => 73, 'mat' => 78, 'ipa' => 83, 'ips' => 80, 'agama' => 77, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 84, 'penjas' => 76],
            ['nisn' => '0106893655', 'bindo' => 84, 'bing' => 72, 'mat' => 76, 'ipa' => 87, 'ips' => 82, 'agama' => 89, 'ppkn' => 81, 'sosbud' => 82, 'tik' => 84, 'penjas' => 83],
            ['nisn' => '0092408141', 'bindo' => 75, 'bing' => 70, 'mat' => 77, 'ipa' => 80, 'ips' => 80, 'agama' => 89, 'ppkn' => 77, 'sosbud' => 80, 'tik' => 80, 'penjas' => 77],
            ['nisn' => '0072916601', 'bindo' => 68, 'bing' => 62, 'mat' => 62, 'ipa' => 75, 'ips' => 78, 'agama' => 74, 'ppkn' => 73, 'sosbud' => 73, 'tik' => 78, 'penjas' => 74],
            ['nisn' => '0086732522', 'bindo' => 73, 'bing' => 60, 'mat' => 68, 'ipa' => 75, 'ips' => 79, 'agama' => 83, 'ppkn' => 73, 'sosbud' => 79, 'tik' => 73, 'penjas' => 74],
            ['nisn' => '0088909950', 'bindo' => 73, 'bing' => 61, 'mat' => 71, 'ipa' => 75, 'ips' => 87, 'agama' => 75, 'ppkn' => 73, 'sosbud' => 79, 'tik' => 77, 'penjas' => 77],
            ['nisn' => '0095765435', 'bindo' => 81, 'bing' => 72, 'mat' => 75, 'ipa' => 87, 'ips' => 81, 'agama' => 98, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 82, 'penjas' => 80],
            ['nisn' => '0095568054', 'bindo' => 75, 'bing' => 71, 'mat' => 74, 'ipa' => 85, 'ips' => 79, 'agama' => 77, 'ppkn' => 73, 'sosbud' => 85, 'tik' => 80, 'penjas' => 82],
            ['nisn' => '0091560342', 'bindo' => 82, 'bing' => 71, 'mat' => 77, 'ipa' => 85, 'ips' => 79, 'agama' => 78, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 79, 'penjas' => 79],
            ['nisn' => '0109734796', 'bindo' => 72, 'bing' => 70, 'mat' => 70, 'ipa' => 77, 'ips' => 79, 'agama' => 85, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 76, 'penjas' => 75],
            ['nisn' => '0103636344', 'bindo' => 82, 'bing' => 71, 'mat' => 75, 'ipa' => 78, 'ips' => 78, 'agama' => 82, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 84, 'penjas' => 80],
            ['nisn' => '0091315738', 'bindo' => 72, 'bing' => 70, 'mat' => 73, 'ipa' => 77, 'ips' => 78, 'agama' => 76, 'ppkn' => 73, 'sosbud' => 75, 'tik' => 78, 'penjas' => 77],
            ['nisn' => '0093468540', 'bindo' => 85, 'bing' => 73, 'mat' => 76, 'ipa' => 87, 'ips' => 78, 'agama' => 78, 'ppkn' => 73, 'sosbud' => 79, 'tik' => 80, 'penjas' => 80],
            ['nisn' => '0092385205', 'bindo' => 72, 'bing' => 70, 'mat' => 66, 'ipa' => 75, 'ips' => 78, 'agama' => 75, 'ppkn' => 73, 'sosbud' => 75, 'tik' => 77, 'penjas' => 75],
            ['nisn' => '0091904596', 'bindo' => 81, 'bing' => 73, 'mat' => 74, 'ipa' => 84, 'ips' => 79, 'agama' => 82, 'ppkn' => 74, 'sosbud' => 80, 'tik' => 79, 'penjas' => 79],
            ['nisn' => '0089416670', 'bindo' => 80, 'bing' => 73, 'mat' => 73, 'ipa' => 80, 'ips' => 81, 'agama' => 82, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 80, 'penjas' => 79],
            ['nisn' => '0091422639', 'bindo' => 82, 'bing' => 74, 'mat' => 68, 'ipa' => 87, 'ips' => 81, 'agama' => 89, 'ppkn' => 74, 'sosbud' => 79, 'tik' => 80, 'penjas' => 80],
            ['nisn' => '0086819205', 'bindo' => 74, 'bing' => 71, 'mat' => 65, 'ipa' => 76, 'ips' => 80, 'agama' => 76, 'ppkn' => 73, 'sosbud' => 79, 'tik' => 81, 'penjas' => 78],
            ['nisn' => '0096573355', 'bindo' => 80, 'bing' => 73, 'mat' => 76, 'ipa' => 84, 'ips' => 80, 'agama' => 78, 'ppkn' => 73, 'sosbud' => 79, 'tik' => 80, 'penjas' => 79],
            ['nisn' => '0075899766', 'bindo' => 81, 'bing' => 79, 'mat' => 74, 'ipa' => 87, 'ips' => 81, 'agama' => 98, 'ppkn' => 81, 'sosbud' => 85, 'tik' => 80, 'penjas' => 77],
            ['nisn' => '0096593074', 'bindo' => 73, 'bing' => 69, 'mat' => 69, 'ipa' => 76, 'ips' => 81, 'agama' => 83, 'ppkn' => 74, 'sosbud' => 80, 'tik' => 78, 'penjas' => 76],
            ['nisn' => '0084727072', 'bindo' => 75, 'bing' => 71, 'mat' => 80, 'ipa' => 77, 'ips' => 81, 'agama' => 83, 'ppkn' => 75, 'sosbud' => 79, 'tik' => 76, 'penjas' => 78],
            ['nisn' => '0082413528', 'bindo' => 81, 'bing' => 73, 'mat' => 68, 'ipa' => 79, 'ips' => 81, 'agama' => 79, 'ppkn' => 77, 'sosbud' => 80, 'tik' => 80, 'penjas' => 78],
            ['nisn' => '0010138589', 'bindo' => 79, 'bing' => 79, 'mat' => 77, 'ipa' => 80, 'ips' => 80, 'agama' => 76, 'ppkn' => 79, 'sosbud' => 80, 'tik' => 80, 'penjas' => 75],
            ['nisn' => '0010501924', 'bindo' => 80, 'bing' => 77, 'mat' => 79, 'ipa' => 76, 'ips' => 79, 'agama' => 78, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 80, 'penjas' => 77],
            ['nisn' => '0011951127', 'bindo' => 78, 'bing' => 77, 'mat' => 79, 'ipa' => 80, 'ips' => 80, 'agama' => 79, 'ppkn' => 73, 'sosbud' => 79, 'tik' => 79, 'penjas' => 76],
            ['nisn' => '0012890356', 'bindo' => 78, 'bing' => 79, 'mat' => 72, 'ipa' => 81, 'ips' => 80, 'agama' => 76, 'ppkn' => 76, 'sosbud' => 78, 'tik' => 77, 'penjas' => 79],
            ['nisn' => '0014864712', 'bindo' => 83, 'bing' => 70, 'mat' => 75, 'ipa' => 79, 'ips' => 77, 'agama' => 76, 'ppkn' => 79, 'sosbud' => 77, 'tik' => 80, 'penjas' => 80],
            ['nisn' => '0016142138', 'bindo' => 73, 'bing' => 79, 'mat' => 73, 'ipa' => 77, 'ips' => 74, 'agama' => 80, 'ppkn' => 80, 'sosbud' => 77, 'tik' => 79, 'penjas' => 79],
            ['nisn' => '0017571235', 'bindo' => 76, 'bing' => 77, 'mat' => 73, 'ipa' => 80, 'ips' => 77, 'agama' => 80, 'ppkn' => 80, 'sosbud' => 77, 'tik' => 81, 'penjas' => 81],
            ['nisn' => '0026204519', 'bindo' => 79, 'bing' => 78, 'mat' => 80, 'ipa' => 84, 'ips' => 75, 'agama' => 79, 'ppkn' => 79, 'sosbud' => 78, 'tik' => 73, 'penjas' => 77],
            ['nisn' => '0029324321', 'bindo' => 79, 'bing' => 78, 'mat' => 77, 'ipa' => 79, 'ips' => 75, 'agama' => 75, 'ppkn' => 81, 'sosbud' => 80, 'tik' => 76, 'penjas' => 73],
            ['nisn' => '0030807916', 'bindo' => 80, 'bing' => 77, 'mat' => 76, 'ipa' => 78, 'ips' => 80, 'agama' => 73, 'ppkn' => 89, 'sosbud' => 72, 'tik' => 77, 'penjas' => 75],
            ['nisn' => '0031752623', 'bindo' => 79, 'bing' => 80, 'mat' => 78, 'ipa' => 79, 'ips' => 80, 'agama' => 75, 'ppkn' => 75, 'sosbud' => 76, 'tik' => 80, 'penjas' => 73],
            ['nisn' => '0037133104', 'bindo' => 79, 'bing' => 79, 'mat' => 77, 'ipa' => 79, 'ips' => 81, 'agama' => 73, 'ppkn' => 75, 'sosbud' => 74, 'tik' => 77, 'penjas' => 73],
            ['nisn' => '0051056398', 'bindo' => 81, 'bing' => 76, 'mat' => 76, 'ipa' => 79, 'ips' => 79, 'agama' => 73, 'ppkn' => 76, 'sosbud' => 76, 'tik' => 75, 'penjas' => 73],
            ['nisn' => '0057221597', 'bindo' => 80, 'bing' => 77, 'mat' => 75, 'ipa' => 81, 'ips' => 77, 'agama' => 76, 'ppkn' => 77, 'sosbud' => 80, 'tik' => 77, 'penjas' => 76],
            ['nisn' => '0058136002', 'bindo' => 73, 'bing' => 77, 'mat' => 79, 'ipa' => 80, 'ips' => 80, 'agama' => 77, 'ppkn' => 77, 'sosbud' => 77, 'tik' => 80, 'penjas' => 77],
            ['nisn' => '0068924695', 'bindo' => 74, 'bing' => 79, 'mat' => 73, 'ipa' => 79, 'ips' => 79, 'agama' => 80, 'ppkn' => 77, 'sosbud' => 73, 'tik' => 80, 'penjas' => 80],
            ['nisn' => '0069004751', 'bindo' => 78, 'bing' => 75, 'mat' => 73, 'ipa' => 77, 'ips' => 73, 'agama' => 80, 'ppkn' => 77, 'sosbud' => 80, 'tik' => 82, 'penjas' => 79],
            ['nisn' => '0071703074', 'bindo' => 79, 'bing' => 73, 'mat' => 72, 'ipa' => 78, 'ips' => 75, 'agama' => 81, 'ppkn' => 78, 'sosbud' => 81, 'tik' => 88, 'penjas' => 73],
            ['nisn' => '0074781906', 'bindo' => 63, 'bing' => 46, 'mat' => 51, 'ipa' => 63, 'ips' => 69, 'agama' => 71, 'ppkn' => 73, 'sosbud' => 72, 'tik' => 53, 'penjas' => 70],
            ['nisn' => '0076702789', 'bindo' => 88, 'bing' => 78, 'mat' => 77, 'ipa' => 80, 'ips' => 73, 'agama' => 74, 'ppkn' => 75, 'sosbud' => 80, 'tik' => 80, 'penjas' => 79],
            ['nisn' => '0079566743', 'bindo' => 79, 'bing' => 78, 'mat' => 75, 'ipa' => 80, 'ips' => 73, 'agama' => 76, 'ppkn' => 74, 'sosbud' => 80, 'tik' => 77, 'penjas' => 84],
            ['nisn' => '0080012437', 'bindo' => 79, 'bing' => 79, 'mat' => 77, 'ipa' => 78, 'ips' => 73, 'agama' => 76, 'ppkn' => 77, 'sosbud' => 79, 'tik' => 79, 'penjas' => 79],
            ['nisn' => '0082433912', 'bindo' => 80, 'bing' => 77, 'mat' => 77, 'ipa' => 79, 'ips' => 80, 'agama' => 78, 'ppkn' => 79, 'sosbud' => 73, 'tik' => 80, 'penjas' => 80],
            ['nisn' => '0083008135', 'bindo' => 73, 'bing' => 81, 'mat' => 78, 'ipa' => 80, 'ips' => 82, 'agama' => 79, 'ppkn' => 80, 'sosbud' => 76, 'tik' => 82, 'penjas' => 80],
            ['nisn' => '0090440076', 'bindo' => 77, 'bing' => 79, 'mat' => 77, 'ipa' => 77, 'ips' => 70, 'agama' => 73, 'ppkn' => 73, 'sosbud' => 77, 'tik' => 77, 'penjas' => 84],
            ['nisn' => '0094161019', 'bindo' => 77, 'bing' => 78, 'mat' => 79, 'ipa' => 78, 'ips' => 80, 'agama' => 77, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 73, 'penjas' => 77],
            ['nisn' => '0095786258', 'bindo' => 79, 'bing' => 79, 'mat' => 77, 'ipa' => 79, 'ips' => 80, 'agama' => 79, 'ppkn' => 73, 'sosbud' => 79, 'tik' => 73, 'penjas' => 79],
            ['nisn' => '0010137225', 'bindo' => 79, 'bing' => 79, 'mat' => 80, 'ipa' => 77, 'ips' => 78, 'agama' => 76, 'ppkn' => 78, 'sosbud' => 77, 'tik' => 77, 'penjas' => 76],
            ['nisn' => '0011171928', 'bindo' => 76, 'bing' => 73, 'mat' => 79, 'ipa' => 73, 'ips' => 87, 'agama' => 75, 'ppkn' => 73, 'sosbud' => 85, 'tik' => 85, 'penjas' => 75],
            ['nisn' => '0011716173', 'bindo' => 79, 'bing' => 75, 'mat' => 73, 'ipa' => 75, 'ips' => 77, 'agama' => 72, 'ppkn' => 73, 'sosbud' => 77, 'tik' => 77, 'penjas' => 70],
            ['nisn' => '0012968942', 'bindo' => 79, 'bing' => 78, 'mat' => 78, 'ipa' => 84, 'ips' => 80, 'agama' => 72, 'ppkn' => 77, 'sosbud' => 79, 'tik' => 79, 'penjas' => 78],
            ['nisn' => '0022137479', 'bindo' => 80, 'bing' => 78, 'mat' => 80, 'ipa' => 84, 'ips' => 88, 'agama' => 77, 'ppkn' => 84, 'sosbud' => 85, 'tik' => 85, 'penjas' => 76],
            ['nisn' => '0027791456', 'bindo' => 80, 'bing' => 80, 'mat' => 82, 'ipa' => 80, 'ips' => 79, 'agama' => 72, 'ppkn' => 75, 'sosbud' => 77, 'tik' => 77, 'penjas' => 77],
            ['nisn' => '0035001248', 'bindo' => 77, 'bing' => 77, 'mat' => 80, 'ipa' => 78, 'ips' => 76, 'agama' => 74, 'ppkn' => 68, 'sosbud' => 83, 'tik' => 83, 'penjas' => 62],
            ['nisn' => '0036908994', 'bindo' => 75, 'bing' => 76, 'mat' => 73, 'ipa' => 73, 'ips' => 89, 'agama' => 89, 'ppkn' => 73, 'sosbud' => 85, 'tik' => 85, 'penjas' => 68],
            ['nisn' => '0041104552', 'bindo' => 77, 'bing' => 81, 'mat' => 79, 'ipa' => 77, 'ips' => 84, 'agama' => 72, 'ppkn' => 73, 'sosbud' => 80, 'tik' => 80, 'penjas' => 71],
            ['nisn' => '0041742537', 'bindo' => 78, 'bing' => 76, 'mat' => 79, 'ipa' => 82, 'ips' => 76, 'agama' => 73, 'ppkn' => 81, 'sosbud' => 83, 'tik' => 83, 'penjas' => 75],
            ['nisn' => '0044310176', 'bindo' => 78, 'bing' => 77, 'mat' => 80, 'ipa' => 80, 'ips' => 76, 'agama' => 73, 'ppkn' => 75, 'sosbud' => 83, 'tik' => 83, 'penjas' => 74],
            ['nisn' => '0046340261', 'bindo' => 73, 'bing' => 79, 'mat' => 85, 'ipa' => 79, 'ips' => 76, 'agama' => 72, 'ppkn' => 82, 'sosbud' => 77, 'tik' => 77, 'penjas' => 77],
            ['nisn' => '0047113495', 'bindo' => 75, 'bing' => 76, 'mat' => 80, 'ipa' => 76, 'ips' => 80, 'agama' => 73, 'ppkn' => 72, 'sosbud' => 79, 'tik' => 73, 'penjas' => 70],
            ['nisn' => '0047525018', 'bindo' => 75, 'bing' => 77, 'mat' => 80, 'ipa' => 84, 'ips' => 89, 'agama' => 75, 'ppkn' => 82, 'sosbud' => 85, 'tik' => 85, 'penjas' => 75],
            ['nisn' => '0056274972', 'bindo' => 78, 'bing' => 75, 'mat' => 80, 'ipa' => 78, 'ips' => 82, 'agama' => 76, 'ppkn' => 72, 'sosbud' => 87, 'tik' => 87, 'penjas' => 73],
            ['nisn' => '0059316094', 'bindo' => 79, 'bing' => 74, 'mat' => 75, 'ipa' => 80, 'ips' => 74, 'agama' => 71, 'ppkn' => 85, 'sosbud' => 75, 'tik' => 75, 'penjas' => 76],
            ['nisn' => '0062345651', 'bindo' => 79, 'bing' => 75, 'mat' => 79, 'ipa' => 77, 'ips' => 89, 'agama' => 75, 'ppkn' => 72, 'sosbud' => 84, 'tik' => 84, 'penjas' => 66],
            ['nisn' => '0067307045', 'bindo' => 79, 'bing' => 73, 'mat' => 75, 'ipa' => 79, 'ips' => 75, 'agama' => 76, 'ppkn' => 81, 'sosbud' => 82, 'tik' => 82, 'penjas' => 74],
            ['nisn' => '0077751308', 'bindo' => 76, 'bing' => 80, 'mat' => 80, 'ipa' => 80, 'ips' => 75, 'agama' => 72, 'ppkn' => 80, 'sosbud' => 75, 'tik' => 75, 'penjas' => 73],
            ['nisn' => '0079439062', 'bindo' => 70, 'bing' => 78, 'mat' => 80, 'ipa' => 80, 'ips' => 76, 'agama' => 72, 'ppkn' => 82, 'sosbud' => 76, 'tik' => 76, 'penjas' => 68],
            ['nisn' => '0081130835', 'bindo' => 76, 'bing' => 47, 'mat' => 48, 'ipa' => 63, 'ips' => 75, 'agama' => 73, 'ppkn' => 74, 'sosbud' => 52, 'tik' => 76, 'penjas' => 65],
            ['nisn' => '0081286174', 'bindo' => 76, 'bing' => 80, 'mat' => 79, 'ipa' => 80, 'ips' => 75, 'agama' => 72, 'ppkn' => 80, 'sosbud' => 76, 'tik' => 76, 'penjas' => 76],
            ['nisn' => '0082171856', 'bindo' => 80, 'bing' => 77, 'mat' => 79, 'ipa' => 80, 'ips' => 90, 'agama' => 78, 'ppkn' => 81, 'sosbud' => 85, 'tik' => 85, 'penjas' => 74],
            ['nisn' => '0082344689', 'bindo' => 79, 'bing' => 81, 'mat' => 85, 'ipa' => 78, 'ips' => 76, 'agama' => 71, 'ppkn' => 73, 'sosbud' => 77, 'tik' => 77, 'penjas' => 69],
            ['nisn' => '0082391613', 'bindo' => 77, 'bing' => 79, 'mat' => 80, 'ipa' => 76, 'ips' => 82, 'agama' => 71, 'ppkn' => 75, 'sosbud' => 76, 'tik' => 76, 'penjas' => 80],
            ['nisn' => '0087250107', 'bindo' => 80, 'bing' => 81, 'mat' => 79, 'ipa' => 80, 'ips' => 76, 'agama' => 71, 'ppkn' => 81, 'sosbud' => 76, 'tik' => 76, 'penjas' => 68],
            ['nisn' => '0089225301', 'bindo' => 79, 'bing' => 73, 'mat' => 80, 'ipa' => 79, 'ips' => 74, 'agama' => 71, 'ppkn' => 73, 'sosbud' => 75, 'tik' => 75, 'penjas' => 79],
        ];

        foreach ($data as &$d) {
            $nilaiMapel = collect($d)->only([
                'bindo', 'bing', 'mat', 'ipa', 'ips', 'agama', 'ppkn', 'sosbud', 'tik', 'penjas'
            ]);

            $jumlah = $nilaiMapel->sum();
            $rata   = $jumlah / $nilaiMapel->count();

            $d['jumlah_nilai'] = $jumlah;
            $d['rata_rata'] = $rata;
            $d['kategori'] = null;
            $d['created_at'] = now();
            $d['updated_at'] = now();
        }

        DB::table('nilai')->insert($data);
    }
}
