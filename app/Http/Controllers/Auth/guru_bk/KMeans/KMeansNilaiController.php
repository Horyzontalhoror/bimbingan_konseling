<?php

namespace App\Http\Controllers\Auth\guru_bk\KMeans;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KMeansNilaiController extends Controller
{
    public function cluster()
    {
        // Ambil data nilai yang memiliki rata-rata
        $data = DB::table('nilai')->whereNotNull('rata_rata')->get();

        // Ambil konfigurasi centroid KMeans bertipe nilai
        $centroids = DB::table('konfigurasi_kmeans')
            ->where('tipe', 'nilai')
            ->orderBy('nama_centroid')
            ->get();

        if ($centroids->count() < 3) {
            return back()->with('error', 'Centroid nilai belum dikonfigurasi.');
        }

        // Cari nilai min dan max untuk normalisasi
        $min = $data->min('rata_rata');
        $max = $data->max('rata_rata');

        foreach ($data as $row) {
            $nisn = $row->nisn;
            $nilaiNorm = ($max != $min) ? ($row->rata_rata - $min) / ($max - $min) : 0;

            // Hitung jarak ke setiap centroid
            $minDist = null;
            $kategori = null;

            foreach ($centroids as $c) {
                $dist = abs($nilaiNorm - $c->centroid);
                if (is_null($minDist) || $dist < $minDist) {
                    $minDist = $dist;
                    $kategori = $c->kategori;
                }
            }

            // Simpan ke tabel rekomendasi_siswa
            DB::table('rekomendasi_siswa')->updateOrInsert(
                ['nisn' => $nisn, 'metode' => 'KMeans-Nilai'],
                [
                    'kategori' => $kategori,
                    'keterangan' => "Kategori \"$kategori\" ditentukan berdasarkan clustering nilai akademik.",
                    'sumber' => 'kmeans-nilai',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // Tandai bahwa proses nilai sudah dijalankan
        session()->put('kmeans.nilai', true);

        // Jika semua step (absen & pelanggaran) sudah dijalankan, tandai siap final
        if (session('kmeans.absen') && session('kmeans.pelanggaran')) {
            session()->put('kmeans.ready', true); // mengaktifkan tombol final
        }

        return back()->with('success', 'Clustering KMeans berdasarkan nilai berhasil dilakukan.');
    }
}
