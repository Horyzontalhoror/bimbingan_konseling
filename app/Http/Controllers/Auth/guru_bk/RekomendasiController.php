<?php

namespace App\Http\Controllers\auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RekomendasiController extends Controller
{
    // Perbandingan Rekomendasi K-Means dan K-NN
    public function perbandingan()
    {
        $siswa = DB::table('rekomendasi_siswa as r1')
            ->join('students', 'r1.nisn', '=', 'students.nisn')
            ->leftJoin('rekomendasi_siswa as r2', function ($join) {
                $join->on('r1.nisn', '=', 'r2.nisn')
                    ->whereColumn('r1.metode', '!=', 'r2.metode');
            })
            ->select(
                'students.name', 'students.class', 'r1.nisn',
                DB::raw("MAX(CASE WHEN r1.metode = 'KMeans' THEN r1.kategori ELSE r2.kategori END) as kmeans"),
                DB::raw("MAX(CASE WHEN r1.metode = 'KNN' THEN r1.kategori ELSE r2.kategori END) as knn")
            )
            ->groupBy('r1.nisn', 'students.name', 'students.class')
            ->get();

        return view('guru_bk.rekomendasi.perbandingan', compact('siswa'));
    }

}
