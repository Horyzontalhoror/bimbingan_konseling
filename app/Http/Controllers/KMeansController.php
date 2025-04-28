<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Nilai;

class KMeansController extends Controller
{
    public function cluster()
    {
        $fields = [
            'bindo', 'bing', 'mat', 'ipa', 'ips',
            'agama', 'ppkn', 'sosbud', 'tik', 'penjas'
        ];

        // Ambil semua data nilai siswa yang memiliki nilai lengkap
        $data = Nilai::select(array_merge(['id'], $fields))
            ->whereNotNull('rata_rata')
            ->get();

        if ($data->count() < 3) {
            return back()->with('error', 'Minimal butuh 3 data untuk clustering.');
        }

        // Normalisasi (karena skala 0-100, cukup dibagi 100)
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

        // Inisialisasi centroid (ambil 3 data acak sebagai awal)
        $centroids = $normalized->random(3)->pluck('vector')->values()->toArray();
        $iteration = 0;
        $maxIterations = 100;
        $clusters = [];

        do {
            $iteration++;
            $clusters = [0 => [], 1 => [], 2 => []];

            // Assign data ke centroid terdekat
            foreach ($normalized as $item) {
                $distances = array_map(fn($c) => $this->euclideanDistance($item['vector'], $c), $centroids);
                $minIndex = array_search(min($distances), $distances);
                $clusters[$minIndex][] = $item;
            }

            $newCentroids = [];
            foreach ($clusters as $cluster) {
                $clusterSize = count($cluster);
                if ($clusterSize == 0) {
                    $newCentroids[] = $centroids[count($newCentroids)];
                    continue;
                }
                $sums = array_fill(0, count($fields), 0);
                foreach ($cluster as $item) {
                    foreach ($item['vector'] as $i => $value) {
                        $sums[$i] += $value;
                    }
                }
                $newCentroids[] = array_map(fn($sum) => $sum / $clusterSize, $sums);
            }

            $changed = json_encode($centroids) !== json_encode($newCentroids);
            $centroids = $newCentroids;

        } while ($changed && $iteration < $maxIterations);

        // Label kategori berdasarkan urutan centroid (nilai rata-rata centroid)
        $centroidAverages = array_map(fn($c) => array_sum($c) / count($c), $centroids);
        asort($centroidAverages);
        $labels = array_values([
            array_search(array_keys($centroidAverages)[0], array_keys($centroids)) => 'Butuh Bimbingan',
            array_search(array_keys($centroidAverages)[1], array_keys($centroids)) => 'Cukup',
            array_search(array_keys($centroidAverages)[2], array_keys($centroids)) => 'Baik',
        ]);

        // Simpan hasil kategori ke database
        foreach ($clusters as $index => $cluster) {
            foreach ($cluster as $item) {
                Nilai::where('id', $item['id'])->update(['kategori' => $labels[$index]]);
            }
        }

        return back()->with('success', 'Clustering berhasil dilakukan.');
    }

    protected function euclideanDistance(array $a, array $b)
    {
        return sqrt(array_sum(array_map(fn($x, $y) => pow($x - $y, 2), $a, $b)));
    }
}
