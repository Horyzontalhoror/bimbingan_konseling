<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil input filter dari query string (jika ada)
        $kategori = request()->input('kategori');
        $kelas = request()->input('kelas');
        $search = trim(request()->input('q'));

        // Ambil data siswa gabungan dari tabel nilai dan students
        $siswa = DB::table('nilai')
            ->join('students', 'nilai.nisn', '=', 'students.nisn')
            ->select(
                'students.name',
                'students.class',
                'nilai.nisn',
                'nilai.rata_rata',
                'nilai.kategori'
            )
            // Filter berdasarkan kategori jika ada
            ->when($kategori, fn($q) => $q->where('nilai.kategori', $kategori))
            // Filter berdasarkan kelas jika ada
            ->when($kelas, fn($q) => $q->where('students.class', $kelas))
            // Filter pencarian nama atau NISN
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('students.name', 'like', "%{$search}%")
                          ->orWhere('nilai.nisn', 'like', "%{$search}%");
                });
            })
            // Urutkan berdasarkan kategori lalu nilai tertinggi
            ->orderBy('kategori')
            ->orderByDesc('rata_rata')
            ->paginate(10)
            // Pastikan pagination membawa query string filter
            ->appends(request()->query());

        // Ambil semua kelas unik untuk dropdown filter
        $semuaKelas = DB::table('students')
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        // Hitung jumlah siswa per kategori (untuk statistik dashboard)
        $statistik = DB::table('nilai')
            ->select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();

        // Kirim data ke view
        return view('guru_bk.dashboard.dashboard', compact('siswa', 'statistik', 'semuaKelas'));
    }
}
