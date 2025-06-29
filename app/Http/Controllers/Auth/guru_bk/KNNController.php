<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KNNController extends Controller
{
    /**
     * Melakukan prediksi kategori siswa yang belum memiliki kategori
     * menggunakan algoritma K-Nearest Neighbors (KNN)
     */
    public function predict()
    {
        // Kolom nilai pelajaran yang digunakan sebagai fitur
        $fields = ['bindo', 'bing', 'mat', 'ipa', 'ips', 'agama', 'ppkn', 'sosbud', 'tik', 'penjas'];

        // Nilai K (jumlah tetangga terdekat yang dipertimbangkan)
        $defaultK = 3;

        // Ambil data training (yang sudah punya kategori)
        $training = Nilai::select(array_merge(['id', 'kategori', 'nisn'], $fields))
            ->whereNotNull('kategori')
            ->get()
            ->map(function ($item) use ($fields) {
                // Normalisasi nilai: dibagi 100 untuk dapatkan skala 0–1
                $vector = [];
                foreach ($fields as $field) {
                    $vector[] = ($item->$field ?? 0) / 100;
                }

                return [
                    'id' => $item->id,
                    'nisn' => $item->nisn,
                    'kategori' => $item->kategori,
                    'vector' => $vector,
                ];
            });

        // Cek jika data training kosong
        if ($training->isEmpty()) {
            return back()->with('error', 'Data training belum tersedia untuk KNN.');
        }

        // Ambil data testing (yang belum memiliki kategori)
        $testing = Nilai::select(array_merge(['id', 'nisn'], $fields))
            ->whereNull('kategori')
            ->get();

        // Prediksi kategori untuk setiap siswa testing
        foreach ($testing as $siswa) {
            // Normalisasi nilai siswa yang diuji
            $vectorBaru = [];
            foreach ($fields as $field) {
                $vectorBaru[] = ($siswa->$field ?? 0) / 100;
            }

            // Hitung jarak ke semua data training
            $jarak = $training->map(function ($train) use ($vectorBaru) {
                return [
                    'kategori' => $train['kategori'],
                    'jarak' => $this->euclideanDistance($train['vector'], $vectorBaru),
                ];
            });

            // Tentukan jumlah K yang bisa digunakan
            $k = min($defaultK, $jarak->count());

            // Ambil K tetangga terdekat
            $nearest = $jarak->sortBy('jarak')->take($k);

            // Voting: kategori terbanyak dari tetangga terdekat
            $prediksi = $nearest->groupBy('kategori')
                ->map(fn($group) => $group->count())
                ->sortDesc()
                ->keys()
                ->first();

            // Simpan hasil prediksi ke tabel `nilai`
            $siswa->kategori = $prediksi;
            $siswa->save();

            // Simpan ke tabel `rekomendasi_siswa`
            DB::table('rekomendasi_siswa')->updateOrInsert(
                ['nisn' => $siswa->nisn, 'metode' => 'KNN'],
                [
                    'kategori' => $prediksi,
                    'keterangan' => "Kategori \"$prediksi\" diprediksi menggunakan KNN berdasarkan $k tetangga terdekat.",
                    'sumber' => 'knn',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Ambil kategori final dari KNN (atau bisa diganti sesuai kebutuhan)
            $kategoriFinal = $prediksi;
            DB::table('rekomendasi_siswa')->updateOrInsert(
                ['nisn' => $siswa->nisn, 'metode' => 'Final'],
                [
                    'kategori' => $kategoriFinal, // misal ambil dari KNN
                    'sumber' => 'final',
                    'keterangan' => 'Rekomendasi final berdasarkan hasil K-NN sebagai metode utama.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

        }

        return back()->with('success', 'Prediksi K-NN selesai dijalankan.');
    }

    /**
     * Fungsi bantu: menghitung jarak Euclidean antara dua vektor
     */
    protected function euclideanDistance(array $a, array $b)
    {
        return sqrt(array_sum(array_map(
            fn($x, $y) => pow($x - $y, 2),
            $a, $b
        )));
    }
}
