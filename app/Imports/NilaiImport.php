<?php

namespace App\Imports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NilaiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Nilai([
            'name' => $row['nama'],
            'nisn' => $row['nisn'],
            'bindo' => $row['bindo'],
            'bing' => $row['bing'],
            'mat' => $row['mat'],
            'ipa' => $row['ipa'],
            'ips' => $row['ips'],
            'agama' => $row['agama'],
            'ppkn' => $row['ppkn'],
            'sosbud' => $row['sos_bud'] ?? $row['sos.bud'],
            'tik' => $row['tik'],
            'penjas' => $row['pen_jasmani'] ?? $row['pen.jasmani'],
            'jumlah_nilai' => $row['jumlah_nilai'],
            'rata_rata' => $row['rata_rata'],
            'class' => $row['class'],
        ]);
    }
}
