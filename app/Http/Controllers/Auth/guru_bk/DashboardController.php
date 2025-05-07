<?php

namespace App\Http\Controllers\Auth\guru_bk;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel students (atau prediksi/hasil cluster kalau sudah disimpan)
        $siswa = DB::table('nilai')
            ->select('name', 'class', 'nisn', 'rata_rata', 'kategori')
            ->when(request('kategori'), fn($q) => $q->where('kategori', request('kategori')))
            ->when(request('kelas'), fn($q) => $q->where('class', request('kelas')))
            ->when(request('q'), function ($q) {
                $q->where(function ($query) {
                    $search = request('q');
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                });
            })
            ->orderBy('kategori')
            ->orderByDesc('rata_rata')
            ->paginate(10)
            ->appends(request()->query()); // ← penting agar filter tetap aktif saat ganti halaman

        // Ambil data kategori untuk filter
        $semuaKelas = DB::table('nilai')
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        // Hitung jumlah per kategori
        $statistik = DB::table('nilai')
            ->select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();


        // return view('dashboard', compact('siswa', 'statistik'));
        return view('guru_bk.dashboard.dashboard', compact('siswa', 'statistik', 'semuaKelas'));
    }
}
