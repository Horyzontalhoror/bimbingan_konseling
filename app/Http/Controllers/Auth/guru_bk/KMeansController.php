<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Nilai;

class KMeansController extends Controller
{
    /**
     * Fungsi utama untuk menjalankan algoritma K-Means Clustering
     * dan mengelompokkan siswa berdasarkan nilai akademik.
     */
    public function cluster()
    {
        // Kolom-kolom mata pelajaran yang digunakan sebagai fitur
        $fields = [
            'bindo', 'bing', 'mat', 'ipa', 'ips',
            'agama', 'ppkn', 'sosbud', 'tik', 'penjas'
        ];

        // Ambil data siswa yang memiliki nilai rata-rata (sudah lengkap)
        $data = Nilai::select(array_merge(['id'], $fields))
            ->whereNotNull('rata_rata')
            ->get();

        // Minimal butuh 3 data agar bisa membentuk 3 cluster
        if ($data->count() < 3) {
            return back()->with('error', 'Minimal butuh 3 data untuk clustering.');
        }

        // Normalisasi data nilai (dibagi 100 supaya dalam rentang 0–1)
        $normalized = $data->map(function ($item) use ($fields) {
            $vector = [];
            foreach ($fields as $field) {
                $vector[] = $item->$field / 100;
            }
            return [
                'id' => $item->id,
                'vector' => $vector,
            ];
        });

        // Inisialisasi 3 centroid pertama secara acak
        $centroids = $normalized->random(3)->pluck('vector')->values()->toArray();

        $iteration = 0;
        $maxIterations = 100;
        $clusters = [];

        do {
            $iteration++;
            // Reset cluster di setiap iterasi
            $clusters = [0 => [], 1 => [], 2 => []];

            // Assign tiap data ke centroid terdekat
            foreach ($normalized as $item) {
                // Hitung jarak ke masing-masing centroid
                $distances = array_map(fn($c) => $this->euclideanDistance($item['vector'], $c), $centroids);
                // Ambil index centroid dengan jarak terkecil
                $minIndex = array_search(min($distances), $distances);
                $clusters[$minIndex][] = $item;
            }

            // Hitung centroid baru berdasarkan rata-rata vektor di masing-masing cluster
            $newCentroids = [];
            foreach ($clusters as $cluster) {
                $clusterSize = count($cluster);
                if ($clusterSize == 0) {
                    // Jika tidak ada data dalam cluster, pakai centroid lama
                    $newCentroids[] = $centroids[count($newCentroids)];
                    continue;
                }

                // Inisialisasi jumlah
                $sums = array_fill(0, count($fields), 0);
                foreach ($cluster as $item) {
                    foreach ($item['vector'] as $i => $value) {
                        $sums[$i] += $value;
                    }
                }

                // Hitung rata-rata (centroid baru)
                $newCentroids[] = array_map(fn($sum) => $sum / $clusterSize, $sums);
            }

            // Cek apakah centroid berubah atau tidak (untuk menghentikan loop)
            $changed = json_encode($centroids) !== json_encode($newCentroids);
            $centroids = $newCentroids;

        } while ($changed && $iteration < $maxIterations);

        // Hitung rata-rata dari setiap centroid untuk menentukan urutan kategori
        $centroidAverages = array_map(fn($c) => array_sum($c) / count($c), $centroids);
        asort($centroidAverages); // Urutkan dari yang terkecil ke terbesar

        // Buat label kategori berdasarkan urutan nilai rata-rata centroid
        // Cluster dengan nilai terendah = "Butuh Bimbingan", dst.
        $labels = array_values([
            array_search(array_keys($centroidAverages)[0], array_keys($centroids)) => 'Butuh Bimbingan',
            array_search(array_keys($centroidAverages)[1], array_keys($centroids)) => 'Cukup',
            array_search(array_keys($centroidAverages)[2], array_keys($centroids)) => 'Baik',
        ]);

        // Simpan hasil label kategori ke database untuk masing-masing siswa
        foreach ($clusters as $index => $cluster) {
            foreach ($cluster as $item) {
                Nilai::where('id', $item['id'])->update(['kategori' => $labels[$index]]);
            }
        }

        return back()->with('success', 'Clustering berhasil dilakukan.');
    }

    /**
     * Fungsi untuk menghitung jarak Euclidean antara dua vektor
     * Digunakan dalam proses pengelompokan data ke centroid terdekat
     */
    protected function euclideanDistance(array $a, array $b)
    {
        return sqrt(array_sum(array_map(fn($x, $y) => pow($x - $y, 2), $a, $b)));
    }
}
