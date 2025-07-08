<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil input filter
        $kategori = request()->input('kategori');
        $kelas = request()->input('kelas');
        $search = trim(request()->input('q'));

        // Data siswa dengan join rekomendasi final
        $query = DB::table('students')
            ->leftJoin('rekomendasi_siswa as nilai', function ($q) {
                $q->on('students.nisn', '=', 'nilai.nisn')->where('nilai.metode', '=', 'KMeans-Nilai');
            })
            ->leftJoin('rekomendasi_siswa as absen', function ($q) {
                $q->on('students.nisn', '=', 'absen.nisn')->where('absen.metode', '=', 'KMeans-Absen');
            })
            ->leftJoin('rekomendasi_siswa as pelanggaran', function ($q) {
                $q->on('students.nisn', '=', 'pelanggaran.nisn')->where('pelanggaran.metode', '=', 'KMeans-Pelanggaran');
            })
            ->leftJoin('rekomendasi_siswa as final', function ($q) {
                $q->on('students.nisn', '=', 'final.nisn')->where('final.metode', '=', 'Final');
            })
            ->select(
                'students.name',
                'students.nisn',
                'students.class',
                DB::raw('COALESCE(nilai.kategori, "-") as nilai'),
                DB::raw('COALESCE(absen.kategori, "-") as absen'),
                DB::raw('COALESCE(pelanggaran.kategori, "-") as pelanggaran'),
                DB::raw('COALESCE(final.kategori, "-") as final')
            );

        // Filter
        if ($kategori) {
            $query->where('final.kategori', $kategori);
        }

        if ($kelas) {
            $query->where('students.class', $kelas);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('students.name', 'like', "%{$search}%")
                    ->orWhere('students.nisn', 'like', "%{$search}%");
            });
        }

        // Order
        $query->orderByRaw("
            FIELD(
                CONCAT_WS('-', nilai.kategori, absen.kategori, pelanggaran.kategori),
                'Butuh Bimbingan-Sering Absen-Sering',
                'Butuh Bimbingan-Sering Absen-Ringan',
                'Butuh Bimbingan-Sering Absen-Tidak Pernah',
                'Butuh Bimbingan-Cukup-Sering',
                'Butuh Bimbingan-Cukup-Ringan',
                'Butuh Bimbingan-Cukup-Tidak Pernah',
                'Butuh Bimbingan-Rajin-Sering',
                'Butuh Bimbingan-Rajin-Ringan',
                'Butuh Bimbingan-Rajin-Tidak Pernah',
                'Cukup-Sering Absen-Sering',
                'Cukup-Sering Absen-Ringan',
                'Cukup-Sering Absen-Tidak Pernah',
                'Cukup-Cukup-Sering',
                'Cukup-Cukup-Ringan',
                'Cukup-Cukup-Tidak Pernah',
                'Cukup-Rajin-Sering',
                'Cukup-Rajin-Ringan',
                'Cukup-Rajin-Tidak Pernah',
                'Baik-Sering Absen-Sering',
                'Baik-Sering Absen-Ringan',
                'Baik-Sering Absen-Tidak Pernah',
                'Baik-Cukup-Sering',
                'Baik-Cukup-Ringan',
                'Baik-Cukup-Tidak Pernah',
                'Baik-Rajin-Sering',
                'Baik-Rajin-Ringan',
                'Baik-Rajin-Tidak Pernah'
            )
        ");

        // Ambil data paginasi
        $siswa = $query->paginate(20)->appends(request()->query());


        // Ambil semua kelas unik
        $semuaKelas = DB::table('students')
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        // Statistik berdasarkan kategori final
        $statistik = DB::table('rekomendasi_siswa')
            ->where('metode', 'Final')
            ->select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->get();

        return view('guru_bk.dashboard.dashboard', compact('siswa', 'semuaKelas', 'statistik'));
    }
}
