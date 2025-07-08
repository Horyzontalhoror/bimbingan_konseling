<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KMeansController extends Controller
{
    // Fungsi keputusan akhir
    // Fungsi ini bertujuan untuk meningkatkan akurasi penentuan kategori siswa.
    // Dengan mempertimbangkan tiga aspek sekaligus (nilai akademik, kehadiran, dan pelanggaran),
    // guru dapat mengambil keputusan yang lebih spesifik dan adil.
    // Pendekatan ini membantu guru memahami faktor utama yang mempengaruhi hasil akhir,
    // sehingga keputusan yang diambil tidak hanya berdasarkan satu aspek saja.
    public function keputusanAkhir()
    {
        // pengambilan database
        $data = DB::table('rekomendasi_siswa as nilai')
            ->select(
                'nilai.nisn',
                'nilai.kategori as kategori_nilai',
                'absen.kategori as kategori_absen',
                'pel.kategori as kategori_pelanggaran'
            )
            ->join('rekomendasi_siswa as absen', function ($join) {
                $join->on('nilai.nisn', '=', 'absen.nisn')
                    ->where('absen.metode', 'KMeans-Absen');
            })
            ->join('rekomendasi_siswa as pel', function ($join) {
                $join->on('nilai.nisn', '=', 'pel.nisn')
                    ->where('pel.metode', 'KMeans-Pelanggaran');
            })
            ->where('nilai.metode', 'KMeans-Nilai')
            ->get();

        // Daftar kombinasi kategori yang digunakan untuk menentukan keputusan akhir.
        // Dengan mendefinisikan kombinasi ini secara eksplisit, proses pengambilan keputusan
        // menjadi lebih transparan, mudah dipahami, dan dapat meningkatkan akurasi hasil akhir.
        // Setiap kombinasi mewakili kondisi siswa berdasarkan nilai akademik, kehadiran, dan pelanggaran.
        $butuhBimbingan = [
            'Butuh Bimbingan-Sering Absen-Sering',
            'Butuh Bimbingan-Sering Absen-Ringan',
            'Butuh Bimbingan-Sering Absen-Tidak Pernah',
            'Butuh Bimbingan-Cukup-Sering',
            'Butuh Bimbingan-Cukup-Ringan',
            'Butuh Bimbingan-Cukup-Tidak Pernah',
            'Butuh Bimbingan-Rajin-Sering',
            'Butuh Bimbingan-Rajin-Ringan',
            'Butuh Bimbingan-Rajin-Tidak Pernah',
        ];

        $cukup = [
            'Cukup-Sering Absen-Sering',
            'Cukup-Sering Absen-Ringan',
            'Cukup-Sering Absen-Tidak Pernah',
            'Cukup-Cukup-Sering',
            'Cukup-Cukup-Ringan',
            'Cukup-Cukup-Tidak Pernah',
            'Cukup-Rajin-Sering',
            'Cukup-Rajin-Ringan',
            'Cukup-Rajin-Tidak Pernah',
        ];

        $baik = [
            'Baik-Sering Absen-Sering',
            'Baik-Sering Absen-Ringan',
            'Baik-Sering Absen-Tidak Pernah',
            'Baik-Cukup-Sering',
            'Baik-Cukup-Ringan',
            'Baik-Cukup-Tidak Pernah',
            'Baik-Rajin-Sering',
            'Baik-Rajin-Ringan',
            'Baik-Rajin-Tidak Pernah',
        ];
        // jumlah kombinasi: 3×3×3=27 kombinasi 👍

        // logika keputusan akhir
        foreach ($data as $row) {
            $nisn = $row->nisn;
            $nilai = $row->kategori_nilai;
            $absen = $row->kategori_absen;
            $pel = $row->kategori_pelanggaran;

            $kombinasi = "{$nilai}-{$absen}-{$pel}";

            // Penentuan keputusan akhir berdasarkan kombinasi
            if (in_array($kombinasi, $butuhBimbingan)) {
                $final = 'Butuh Bimbingan';
            } elseif (in_array($kombinasi, $cukup)) {
                $final = 'Cukup';
            } else {
                $final = 'Baik';
            }

            // Catatan penyebab dominan
            $penyebab = [];
            if ($nilai === 'Butuh Bimbingan') $penyebab[] = 'akademik buruk';
            if ($absen === 'Sering Absen') $penyebab[] = 'sering tidak hadir';
            if ($pel === 'Sering') $penyebab[] = 'banyak pelanggaran';

            $keterangan = !empty($penyebab)
                ? 'Faktor utama: ' . implode(', ', $penyebab)
                : "Kategori akhir dari kombinasi ($nilai, $absen, $pel)";

            DB::table('rekomendasi_siswa')->updateOrInsert(
                ['nisn' => $nisn, 'metode' => 'Final'],
                [
                    'kategori' => $final,
                    'sumber' => 'final',
                    'keterangan' => $keterangan,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return back()->with('success', 'Keputusan akhir berdasarkan kombinasi kategori telah ditentukan.');
    }
}
