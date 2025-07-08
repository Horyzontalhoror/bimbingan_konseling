<?php

namespace App\Http\Controllers\Auth\guru_bk\KMeans;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KMeansAbsenController extends Controller
{
    public function cluster()
    {
        // Ambil data total absen (alpa + bolos) per siswa
        $absensi = DB::table('absensi')
            ->select('nisn', DB::raw('SUM(alpa + bolos) as jumlah_absen'))
            ->groupBy('nisn')
            ->get();

        // K1 → centroids[0]
        // K2 → centroids[1]
        // K3 → centroids[2]
        // Ambil centroid khusus untuk absen
        $centroids = DB::table('konfigurasi_kmeans')
            ->where('tipe', 'absen')
            ->orderBy('nama_centroid')
            ->get();

        if ($centroids->count() < 3) {
            return back()->with('error', 'Centroid absen belum lengkap.');
        }

        // Cari nilai min-max untuk normalisasi
        $min = $absensi->min('jumlah_absen');
        $max = $absensi->max('jumlah_absen');

        foreach ($absensi as $row) {
            $nisn = $row->nisn;
            $jumlah = $row->jumlah_absen;

            $absenNorm = ($jumlah - $min) / max(($max - $min), 1);

            // Cari jarak terdekat ke centroid absen
            $minDist = null;
            $kategori = null;

            foreach ($centroids as $c) {
                $dist = abs($absenNorm - $c->centroid);
                if (is_null($minDist) || $dist < $minDist) {
                    $minDist = $dist;
                    $kategori = $c->kategori;
                }
            }

            // Simpan hasil ke tabel rekomendasi_siswa
            DB::table('rekomendasi_siswa')->updateOrInsert(
                ['nisn' => $nisn, 'metode' => 'KMeans-Absen'],
                [
                    'kategori' => $kategori,
                    'keterangan' => "Kategori \"$kategori\" ditentukan berdasarkan clustering absensi (alpa + bolos).",
                    'sumber' => 'kmeans-absen',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return back()->with('success', 'Clustering KMeans berdasarkan absen berhasil dilakukan.');
    }
}
