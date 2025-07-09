<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KNNController extends Controller
{
    public function predict(Request $request)
    {
        $k = 3;

        // Ambil siswa yang perlu diprediksi ulang
        $siswaBaru = DB::table('students')->where('is_predicted', false)->pluck('nisn');
        if ($siswaBaru->isEmpty()) {
            return back()->with('info', 'Tidak ada siswa yang perlu diproses ulang.');
        }

        // === KNN NILAI ===
        $fields = ['bindo', 'bing', 'mat', 'ipa', 'ips', 'agama', 'ppkn', 'sosbud', 'tik', 'penjas'];
        $trainNilai = DB::table('rekomendasi_siswa')->where('metode', 'KMeans-Nilai')->get();
        $nilaiTrain = DB::table('nilai')->whereIn('nisn', $trainNilai->pluck('nisn'))->get()->keyBy('nisn');
        $testNilai = DB::table('nilai')->whereIn('nisn', $siswaBaru)->get();

        foreach ($testNilai as $siswa) {
            $vectorTest = collect($fields)->map(fn($f) => ($siswa->$f ?? 0) / 100)->toArray();

            $distances = $trainNilai->map(function ($row) use ($nilaiTrain, $vectorTest, $fields) {
                $data = $nilaiTrain[$row->nisn] ?? null;
                if (!$data) return null;

                $vectorTrain = collect($fields)->map(fn($f) => ($data->$f ?? 0) / 100)->toArray();
                return [
                    'kategori' => $row->kategori,
                    'jarak' => $this->euclideanDistance($vectorTrain, $vectorTest)
                ];
            })->filter();

            $kategori = $distances->sortBy('jarak')->take($k)->groupBy('kategori')->map->count()->sortDesc()->keys()->first();

            if ($kategori) {
                DB::table('rekomendasi_siswa')->updateOrInsert([
                    'nisn' => $siswa->nisn,
                    'metode' => 'KNN-Nilai',
                ], [
                    'kategori' => $kategori,
                    'sumber' => 'knn',
                    'keterangan' => 'Diklasifikasi dari siswa KMeans-Nilai.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // === KNN ABSEN ===
        $trainAbsen = DB::table('rekomendasi_siswa')->where('metode', 'KMeans-Absen')->get();
        $absenTrain = DB::table('absensi')
            ->select('nisn', DB::raw('SUM(alpa + bolos) as jumlah'))
            ->whereIn('nisn', $trainAbsen->pluck('nisn'))
            ->groupBy('nisn')
            ->get();

        $testAbsen = DB::table('absensi')
            ->select('nisn', DB::raw('SUM(alpa + bolos) as jumlah'))
            ->whereIn('nisn', $siswaBaru)
            ->groupBy('nisn')
            ->get();

        foreach ($testAbsen as $siswa) {
            $distances = $absenTrain->map(function ($train) use ($siswa, $trainAbsen) {
                $kategori = $trainAbsen->firstWhere('nisn', $train->nisn)->kategori ?? null;
                return [
                    'kategori' => $kategori,
                    'jarak' => abs($train->jumlah - $siswa->jumlah)
                ];
            });

            $kategori = $distances->sortBy('jarak')->take($k)->groupBy('kategori')->map->count()->sortDesc()->keys()->first();

            if ($kategori) {
                DB::table('rekomendasi_siswa')->updateOrInsert([
                    'nisn' => $siswa->nisn,
                    'metode' => 'KNN-Absen',
                ], [
                    'kategori' => $kategori,
                    'sumber' => 'knn',
                    'keterangan' => 'Diklasifikasi dari siswa KMeans-Absen.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // === KNN PELANGGARAN ===
        $trainPel = DB::table('rekomendasi_siswa')->where('metode', 'KMeans-Pelanggaran')->get();
        $pelTrain = DB::table('violations')
            ->join('jenis_pelanggaran', 'jenis_pelanggaran.id', '=', 'violations.jenis_pelanggaran_id')
            ->select('violations.nisn', DB::raw('SUM(jenis_pelanggaran.poin) as jumlah'))
            ->whereIn('violations.nisn', $trainPel->pluck('nisn'))
            ->groupBy('violations.nisn')
            ->get();

        $pelTest = DB::table('students')
            ->leftJoin('violations', 'students.nisn', '=', 'violations.nisn')
            ->leftJoin('jenis_pelanggaran', 'jenis_pelanggaran.id', '=', 'violations.jenis_pelanggaran_id')
            ->select('students.nisn', DB::raw('COALESCE(SUM(jenis_pelanggaran.poin), 0) as jumlah'))
            ->whereIn('students.nisn', $siswaBaru)
            ->groupBy('students.nisn')
            ->get();

        foreach ($pelTest as $siswa) {
            if ($siswa->jumlah == 0) {
                // Kategorikan langsung sebagai 'Tidak Pernah'
                DB::table('rekomendasi_siswa')->updateOrInsert([
                    'nisn' => $siswa->nisn,
                    'metode' => 'KNN-Pelanggaran',
                ], [
                    'kategori' => 'Tidak Pernah',
                    'sumber' => 'manual',
                    'keterangan' => 'Tidak memiliki data pelanggaran, dikategorikan sebagai Tidak Pernah.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                continue; // Skip KNN
            }

            $distances = $pelTrain->map(function ($train) use ($siswa, $trainPel) {
                $kategori = $trainPel->firstWhere('nisn', $train->nisn)->kategori ?? null;
                return [
                    'kategori' => $kategori,
                    'jarak' => abs($train->jumlah - $siswa->jumlah)
                ];
            });

            $kategori = $distances->sortBy('jarak')->take($k)->groupBy('kategori')->map->count()->sortDesc()->keys()->first();

            if ($kategori) {
                DB::table('rekomendasi_siswa')->updateOrInsert([
                    'nisn' => $siswa->nisn,
                    'metode' => 'KNN-Pelanggaran',
                ], [
                    'kategori' => $kategori,
                    'sumber' => 'knn',
                    'keterangan' => 'Diklasifikasi dari siswa KMeans-Pelanggaran.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // === FINAL DECISION BASED ON KNN ===
        $finalData = DB::table('students')
            ->leftJoin('rekomendasi_siswa as nilai', function ($q) {
                $q->on('students.nisn', '=', 'nilai.nisn')->where('nilai.metode', 'KNN-Nilai');
            })
            ->leftJoin('rekomendasi_siswa as absen', function ($q) {
                $q->on('students.nisn', '=', 'absen.nisn')->where('absen.metode', 'KNN-Absen');
            })
            ->leftJoin('rekomendasi_siswa as pel', function ($q) {
                $q->on('students.nisn', '=', 'pel.nisn')->where('pel.metode', 'KNN-Pelanggaran');
            })
            ->whereIn('students.nisn', $siswaBaru)
            ->select(
                'students.nisn',
                DB::raw('COALESCE(nilai.kategori, "-") as kategori_nilai'),
                DB::raw('COALESCE(absen.kategori, "-") as kategori_absen'),
                DB::raw('COALESCE(pel.kategori, "-") as kategori_pelanggaran')
            )
            ->get();

        $recordsFinal = [];
        $timestamp = now();

        foreach ($finalData as $row) {
            $nisn = $row->nisn;
            $nilai = $row->kategori_nilai;
            $absen = $row->kategori_absen;
            $pel = $row->kategori_pelanggaran;

            $final = 'Baik';

            if ($nilai === 'Butuh Bimbingan' || $absen === 'Sering Absen' || $pel === 'Sering') {
                $final = 'Butuh Bimbingan';
            } elseif ($nilai === 'Cukup' || $absen === 'Cukup' || $pel === 'Ringan') {
                $final = 'Cukup';
            }

            $recordsFinal[] = [
                'nisn' => $nisn,
                'metode' => 'Final',
                'kategori' => $final,
                'sumber' => 'knn',
                'keterangan' => "Kategori akhir dari kombinasi (Nilai: $nilai, Absen: $absen, Pelanggaran: $pel)",
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }

        // FILTER DUPLIKASI SETELAH PENGISIAN
        $recordsFinal = collect($recordsFinal)
            ->unique(fn($item) => $item['nisn'] . '-' . $item['metode'])
            ->values()
            ->all();


        if (!empty($recordsFinal)) {
            DB::table('rekomendasi_siswa')->upsert(
                $recordsFinal,
                ['nisn', 'metode'],
                ['kategori', 'sumber', 'keterangan', 'updated_at']
            );
        }

        // Tandai siswa sudah diprediksi
        DB::table('students')->whereIn('nisn', $siswaBaru)->update(['is_predicted' => true]);

        return back()->with('success', 'Klasifikasi KNN selesai untuk siswa yang perlu diproses ulang.');
    }

    protected function euclideanDistance(array $a, array $b)
    {
        return sqrt(array_sum(array_map(fn($x, $y) => pow($x - $y, 2), $a, $b)));
    }
}
