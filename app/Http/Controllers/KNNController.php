<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KNNController extends Controller
{
    public function predict()
    {
        $fields = [
            'bindo', 'bing', 'mat', 'ipa', 'ips',
            'agama', 'ppkn', 'sosbud', 'tik', 'penjas'
        ];

        $k = 3;

        // Ambil data training (yang sudah punya kategori)
        $training = Nilai::select(array_merge(['id', 'kategori'], $fields))
            ->whereNotNull('kategori')
            ->get()
            ->map(function ($item) use ($fields) {
                $vector = [];
                foreach ($fields as $field) {
                    $vector[] = $item->$field / 100;
                }
                return [
                    'id' => $item->id,
                    'kategori' => $item->kategori,
                    'vector' => $vector
                ];
            });

        // Ambil data testing (yang belum punya kategori)
        $testing = Nilai::select(array_merge(['id'], $fields))
            ->whereNull('kategori')
            ->get();

        foreach ($testing as $siswa) {
            $vectorBaru = [];
            foreach ($fields as $field) {
                $vectorBaru[] = $siswa->$field / 100;
            }

            // Hitung jarak ke semua data training
            $jarak = $training->map(function ($train) use ($vectorBaru) {
                return [
                    'kategori' => $train['kategori'],
                    'jarak' => $this->euclideanDistance($train['vector'], $vectorBaru)
                ];
            });

            // Ambil k tetangga terdekat
            $nearest = $jarak->sortBy('jarak')->take($k);

            // Voting kategori terbanyak
            $prediksi = $nearest->groupBy('kategori')
                ->map(fn($g) => $g->count())
                ->sortDesc()
                ->keys()
                ->first();

            // Simpan hasil prediksi ke database
            $siswa->kategori = $prediksi;
            $siswa->save();
        }

        return back()->with('success', 'Prediksi K-NN selesai dijalankan.');
    }

    protected function euclideanDistance(array $a, array $b)
    {
        return sqrt(array_sum(array_map(fn($x, $y) => pow($x - $y, 2), $a, $b)));
    }
}
