<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Nilai;

class KMeansController extends Controller
{
    public function cluster()
    {
        // Kolom-kolom nilai yang digunakan sebagai fitur
        $fields = ['bindo', 'bing', 'mat', 'ipa', 'ips', 'agama', 'ppkn', 'sosbud', 'tik', 'penjas'];

        // Ambil data siswa yang sudah punya rata-rata (artinya nilai lengkap)
        $data = Nilai::select(array_merge(['id', 'nisn'], $fields))
            ->whereNotNull('rata_rata')
            ->get();

        if ($data->count() < 3) {
            return back()->with('error', 'Minimal butuh 3 data untuk clustering.');
        }

        // Normalisasi nilai (dalam rentang 0–1)
        $normalized = $data->map(function ($item) use ($fields) {
            $vector = [];
            foreach ($fields as $field) {
                $vector[] = ($item->$field ?? 0) / 100;
            }
            return [
                'id' => $item->id,
                'nisn' => $item->nisn,
                'vector' => $vector,
            ];
        });

        $centroidNames = ['K1', 'K2', 'K3'];

        // Ambil konfigurasi centroid dari DB (jika tersedia)
        $existingCentroids = DB::table('konfigurasi_kmeans')
            ->orderBy('nama_centroid')
            ->pluck('nilai_centroid')
            ->toArray();

        // Jika konfigurasi sudah ada, pakai sebagai centroid awal
        if (count($existingCentroids) === 3) {
            $centroids = array_map(function ($avg) use ($fields) {
                return array_fill(0, count($fields), (float) $avg);
            }, $existingCentroids);
        } else {
            // Kalau belum ada konfigurasi, random centroid awal dari data
            $centroids = $normalized->random(3)->pluck('vector')->values()->toArray();
        }

        $iteration = 0;
        $maxIterations = 100;
        $clusters = [];

        // Iterasi K-Means
        do {
            $iteration++;
            $clusters = [0 => [], 1 => [], 2 => []];

            foreach ($normalized as $item) {
                // Hitung jarak Euclidean ke tiap centroid
                $distances = array_map(fn($c) => $this->euclideanDistance($item['vector'], $c), $centroids);
                $minIndex = array_search(min($distances), $distances);
                $clusters[$minIndex][] = $item;
            }

            // Update centroid baru dari tiap cluster
            $newCentroids = [];
            foreach ($clusters as $cluster) {
                $size = count($cluster);
                if ($size === 0) {
                    $newCentroids[] = $centroids[count($newCentroids)];
                    continue;
                }

                $sums = array_fill(0, count($fields), 0);
                foreach ($cluster as $item) {
                    foreach ($item['vector'] as $i => $value) {
                        $sums[$i] += $value;
                    }
                }
                $newCentroids[] = array_map(fn($sum) => $sum / $size, $sums);
            }

            $changed = json_encode($centroids) !== json_encode($newCentroids);
            $centroids = $newCentroids;
        } while ($changed && $iteration < $maxIterations);

        // Ambil label kategori dari DB berdasarkan urutan tetap: Cluster 0 = K1, dst.
        $configs = DB::table('konfigurasi_kmeans')->pluck('kategori', 'nama_centroid');
        $labels = [];
        foreach ($centroidNames as $i => $kname) {
            $labels[$i] = $configs->get($kname, 'Tidak Dikenal');
        }

        // Jika belum ada konfigurasi, simpan konfigurasi centroid dari hasil clustering
        if ($configs->isEmpty()) {
            foreach ($centroids as $i => $centroid) {
                $avg = array_sum($centroid) / count($centroid);
                $kategori = ['Butuh Bimbingan', 'Cukup', 'Baik'][$i]; // default urutan awal
                DB::table('konfigurasi_kmeans')->insert([
                    'nama_centroid' => $centroidNames[$i],
                    'nilai_centroid' => round($avg, 4),
                    'kategori' => $kategori,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $labels[$i] = $kategori;
            }
        }

        // Simpan hasil cluster ke tabel nilai dan rekomendasi siswa
        foreach ($clusters as $index => $cluster) {
            foreach ($cluster as $item) {
                $kategori = $labels[$index];
                $keterangan = "Kategori \"$kategori\" ditentukan melalui metode K-Means pada iterasi ke-$iteration.";

                // Update kategori siswa di tabel nilai
                DB::table('nilai')->where('id', $item['id'])->update(['kategori' => $kategori]);

                // Simpan ke tabel rekomendasi_siswa
                DB::table('rekomendasi_siswa')->updateOrInsert(
                    ['nisn' => $item['nisn'], 'metode' => 'KMeans'],
                    [
                        'kategori' => $kategori,
                        'keterangan' => $keterangan,
                        'sumber' => 'kmeans',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }

        return back()->with([
            'success' => 'Clustering berhasil dilakukan.',
            'info' => "Iterasi selesai dalam $iteration kali.",
        ]);
    }

    // Fungsi bantu untuk menghitung jarak Euclidean
    protected function euclideanDistance(array $a, array $b)
    {
        return sqrt(array_sum(array_map(
            fn($x, $y) => pow($x - $y, 2),
            $a, $b
        )));
    }
}
