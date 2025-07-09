<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RekomendasiController extends Controller
{
    public function perbandingan()
    {
        // Ambil siswa yang memiliki data KMeans
        $kmeans = DB::table('students')
            ->join(DB::raw("(
                SELECT DISTINCT nisn FROM rekomendasi_siswa
                WHERE metode IN ('KMeans-Nilai', 'KMeans-Absen', 'KMeans-Pelanggaran')
            ) as filtered"), 'students.nisn', '=', 'filtered.nisn')

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
                DB::raw('COALESCE(nilai.kategori, "-") as nilai_kmeans'),
                DB::raw('COALESCE(absen.kategori, "-") as absen_kmeans'),
                DB::raw('COALESCE(pelanggaran.kategori, "-") as pelanggaran_kmeans'),
                DB::raw('COALESCE(final.kategori, "-") as final')
            )
            ->orderBy('students.name')
            ->get();

        // Ambil siswa yang memiliki data KNN
        $knn = DB::table('students')
            ->join(DB::raw("(
                SELECT DISTINCT nisn FROM rekomendasi_siswa
                WHERE metode IN ('KNN-Nilai', 'KNN-Absen', 'KNN-Pelanggaran')
            ) as filtered"), 'students.nisn', '=', 'filtered.nisn')

            ->leftJoin('rekomendasi_siswa as nilai', function ($q) {
                $q->on('students.nisn', '=', 'nilai.nisn')
                    ->where('nilai.metode', '=', 'KNN-Nilai');
            })
            ->leftJoin('rekomendasi_siswa as absen', function ($q) {
                $q->on('students.nisn', '=', 'absen.nisn')
                    ->where('absen.metode', '=', 'KNN-Absen');
            })
            ->leftJoin('rekomendasi_siswa as pelanggaran', function ($q) {
                $q->on('students.nisn', '=', 'pelanggaran.nisn')
                    ->where('pelanggaran.metode', '=', 'KNN-Pelanggaran');
            })
            ->select(
                'students.name',
                'students.nisn',
                'students.class',
                DB::raw('COALESCE(nilai.kategori, "-") as nilai_knn'),
                DB::raw('COALESCE(absen.kategori, "-") as absen_knn'),
                DB::raw('COALESCE(pelanggaran.kategori, "-") as pelanggaran_knn')
            )
            ->orderBy('students.name')
            ->get();

        return view('guru_bk.rekomendasi.perbandingan', [
            'kmeans' => $kmeans,
            'knn' => $knn
        ]);
    }
}
