<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
// use Illuminate\Pagination\LengthAwarePaginator; // Tidak diperlukan lagi
// use Illuminate\Support\Collection; // Tidak diperlukan lagi

class RekomendasiController extends Controller
{
    /**
     * Menampilkan perbandingan rekomendasi siswa berdasarkan hasil K-Means.
     * Menggabungkan data siswa dengan hasil clustering dari berbagai metode K-Means
     * (Nilai, Absen, Pelanggaran) dan keputusan akhir.
     *
     * @return \Illuminate\View\View
     */
    public function perbandingan()
    {
        $data = DB::table('students')
            ->leftJoin('rekomendasi_siswa as nilai', function ($q) {
                $q->on('students.nisn', '=', 'nilai.nisn')
                    ->where('nilai.metode', '=', 'KMeans-Nilai');
            })
            ->leftJoin('rekomendasi_siswa as absen', function ($q) {
                $q->on('students.nisn', '=', 'absen.nisn')
                    ->where('absen.metode', '=', 'KMeans-Absen');
            })
            ->leftJoin('rekomendasi_siswa as pelanggaran', function ($q) {
                $q->on('students.nisn', '=', 'pelanggaran.nisn')
                    ->where('pelanggaran.metode', '=', 'KMeans-Pelanggaran');
            })
            ->leftJoin('rekomendasi_siswa as final', function ($q) {
                $q->on('students.nisn', '=', 'final.nisn')
                    ->where('final.metode', '=', 'Final');
            })
            ->select(
                'students.name',
                'students.nisn',
                'students.class',
                DB::raw('COALESCE(nilai.kategori, "-") as nilai'),
                DB::raw('COALESCE(absen.kategori, "-") as absen'),
                DB::raw('COALESCE(pelanggaran.kategori, "-") as pelanggaran'),
                DB::raw('COALESCE(final.kategori, "-") as final')
            )
            ->orderByRaw("
                FIELD(nilai.kategori, 'Butuh Bimbingan', 'Cukup', 'Baik'),
                FIELD(absen.kategori, 'Sering Absen', 'Cukup', 'Rajin'),
                FIELD(pelanggaran.kategori, 'Sering', 'Ringan', 'Tidak Pernah')
            ")
            ->get(); // Ambil semua data

        // Tidak ada lagi paginasi manual di sini.
        // DataTables akan menangani paginasi di sisi klien.

        return view('guru_bk.rekomendasi.perbandingan', ['siswa' => $data]);
    }
}
