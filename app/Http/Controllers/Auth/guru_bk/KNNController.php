<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;

class KNNController extends Controller
{
    /**
     * Fungsi utama untuk melakukan prediksi kategori siswa
     * menggunakan algoritma K-Nearest Neighbors (KNN)
     */
    public function predict()
    {
        // Daftar nama-nama kolom nilai pelajaran
        $fields = [
            'bindo', 'bing', 'mat', 'ipa', 'ips',
            'agama', 'ppkn', 'sosbud', 'tik', 'penjas'
        ];

        // Jumlah tetangga terdekat yang akan digunakan
        $k = 3;

        // Ambil data training (data yang sudah memiliki kategori)
        $training = Nilai::select(array_merge(['id', 'kategori'], $fields))
            ->whereNotNull('kategori') // hanya yang sudah ada kategorinya
            ->get()
            ->map(function ($item) use ($fields) {
                // Normalisasi nilai (dibagi 100 agar semua nilai dalam skala 0–1)
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

        // Ambil data testing (siswa yang belum memiliki kategori)
        $testing = Nilai::select(array_merge(['id'], $fields))
            ->whereNull('kategori') // hanya data yang belum punya kategori
            ->get();

        // Loop setiap data testing untuk diprediksi kategorinya
        foreach ($testing as $siswa) {
            // Normalisasi nilai siswa (dibagi 100)
            $vectorBaru = [];
            foreach ($fields as $field) {
                $vectorBaru[] = $siswa->$field / 100;
            }

            // Hitung jarak Euclidean ke semua data training
            $jarak = $training->map(function ($train) use ($vectorBaru) {
                return [
                    'kategori' => $train['kategori'],
                    'jarak' => $this->euclideanDistance($train['vector'], $vectorBaru)
                ];
            });

            // Urutkan berdasarkan jarak terkecil, lalu ambil K terdekat
            $nearest = $jarak->sortBy('jarak')->take($k);

            // Voting kategori berdasarkan jumlah kemunculan terbanyak
            $prediksi = $nearest->groupBy('kategori')
                ->map(fn($g) => $g->count())   // hitung jumlah kategori
                ->sortDesc()                   // urutkan dari yang paling banyak
                ->keys()                       // ambil nama kategorinya
                ->first();                     // ambil kategori terbanyak

            // Simpan hasil prediksi ke database
            $siswa->kategori = $prediksi;
            $siswa->save();
        }

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Prediksi K-NN selesai dijalankan.');
    }

    /**
     * Fungsi untuk menghitung jarak Euclidean antara dua vektor
     * @param array $a vektor 1 (data training)
     * @param array $b vektor 2 (data testing)
     * @return float jarak Euclidean
     */
    protected function euclideanDistance(array $a, array $b)
    {
        // Hitung jumlah kuadrat selisih antar elemen vektor
        return sqrt(array_sum(array_map(fn($x, $y) => pow($x - $y, 2), $a, $b)));
    }
}
