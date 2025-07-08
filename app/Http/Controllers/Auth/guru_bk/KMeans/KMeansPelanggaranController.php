<?php

namespace App\Http\Controllers\Auth\guru_bk\KMeans;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KMeansPelanggaranController extends Controller
{
    public function cluster()
    {
        // Ambil semua NISN siswa
        $semuaSiswa = DB::table('students')->pluck('nisn');

        // Ambil jumlah pelanggaran per siswa (hanya yang punya pelanggaran)
        $pelanggaran = DB::table('violations')
            ->join('students', 'students.nisn', '=', 'violations.nisn')
            ->select('students.nisn', DB::raw('COUNT(*) as jumlah_pelanggaran'))
            ->groupBy('students.nisn')
            ->get()
            ->keyBy('nisn');

        // Ambil centroid khusus tipe pelanggaran
        $centroids = DB::table('konfigurasi_kmeans')
            ->where('tipe', 'pelanggaran')
            ->orderBy('nama_centroid')
            ->get();

        if ($centroids->count() < 3) {
            return back()->with('error', 'Centroid pelanggaran belum lengkap.');
        }

        // Normalisasi: ambil nilai minimum dan maksimum (termasuk yang tidak punya pelanggaran, dianggap 0)
        $jumlahSemua = $semuaSiswa->map(function ($nisn) use ($pelanggaran) {
            return $pelanggaran[$nisn]->jumlah_pelanggaran ?? 0;
        });

        $min = $jumlahSemua->min();
        $max = $jumlahSemua->max();

        foreach ($semuaSiswa as $nisn) {
            $jumlah = $pelanggaran[$nisn]->jumlah_pelanggaran ?? 0;

            // Normalisasi
            $pelNorm = ($jumlah - $min) / max(($max - $min), 1);

            // Hitung jarak ke setiap centroid
            $minDist = null;
            $kategori = null;

            foreach ($centroids as $c) {
                $dist = abs($pelNorm - $c->centroid);
                if (is_null($minDist) || $dist < $minDist) {
                    $minDist = $dist;
                    $kategori = $c->kategori;
                }
            }

            // Simpan hasil ke rekomendasi_siswa
            DB::table('rekomendasi_siswa')->updateOrInsert(
                ['nisn' => $nisn, 'metode' => 'KMeans-Pelanggaran'],
                [
                    'kategori' => $kategori,
                    'keterangan' => "Kategori \"$kategori\" ditentukan berdasarkan clustering jumlah pelanggaran siswa.",
                    'sumber' => 'kmeans-pelanggaran',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        return back()->with('success', 'Clustering KMeans berdasarkan pelanggaran berhasil dilakukan untuk semua siswa.');
    }
}
