<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KNNController extends Controller
{
    public function predict(Request $request)
    {
        $k = 3;

        // --------- KNN NILAI ---------
        $fields = ['bindo', 'bing', 'mat', 'ipa', 'ips', 'agama', 'ppkn', 'sosbud', 'tik', 'penjas'];
        $trainingNilai = DB::table('rekomendasi_siswa')->where('metode', 'KNN-Nilai')->get();
        $testingNilai = DB::table('nilai')
            ->whereNotIn('nisn', $trainingNilai->pluck('nisn'))
            ->get();

        foreach ($testingNilai as $siswa) {
            $vectorBaru = collect($fields)->map(fn($f) => ($siswa->$f ?? 0) / 100)->toArray();

            $distances = $trainingNilai->map(function ($train) use ($fields, $vectorBaru) {
                $nilaiTrain = DB::table('nilai')->where('nisn', $train->nisn)->first();
                $vectorTrain = collect($fields)->map(fn($f) => ($nilaiTrain->$f ?? 0) / 100)->toArray();
                return [
                    'kategori' => $train->kategori,
                    'jarak' => $this->euclideanDistance($vectorTrain, $vectorBaru)
                ];
            });

            $kategori = $distances->sortBy('jarak')->take($k)->groupBy('kategori')->map->count()->sortDesc()->keys()->first();

            DB::table('rekomendasi_siswa')->updateOrInsert([
                'nisn' => $siswa->nisn,
                'metode' => 'KNN-Nilai',
            ], [
                'kategori' => $kategori,
                'sumber' => 'knn',
                'keterangan' => 'Kategori nilai diprediksi dengan KNN.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // --------- KNN ABSEN ---------
        $trainingAbsen = DB::table('rekomendasi_siswa')->where('metode', 'KNN-Absen')->pluck('nisn');
        $dataTrainAbsen = DB::table('absensi')
            ->select('nisn', DB::raw('SUM(alpa + bolos) as jumlah'))
            ->whereIn('nisn', $trainingAbsen)
            ->groupBy('nisn')
            ->get();

        $allNisn = DB::table('nilai')->pluck('nisn');
        $testingAbsen = $allNisn->diff($trainingAbsen);
        $dataTestAbsen = DB::table('absensi')
            ->select('nisn', DB::raw('SUM(alpa + bolos) as jumlah'))
            ->whereIn('nisn', $testingAbsen)
            ->groupBy('nisn')
            ->get();

        foreach ($dataTestAbsen as $test) {
            $jarak = $dataTrainAbsen->map(function ($train) use ($test) {
                $kategori = DB::table('rekomendasi_siswa')
                    ->where('nisn', $train->nisn)
                    ->where('metode', 'KNN-Absen')
                    ->value('kategori');

                return [
                    'nisn' => $train->nisn,
                    'jarak' => abs($train->jumlah - $test->jumlah),
                    'kategori' => $kategori,
                ];
            });

            $kategori = $jarak->sortBy('jarak')->take($k)->groupBy('kategori')->map->count()->sortDesc()->keys()->first();

            DB::table('rekomendasi_siswa')->updateOrInsert([
                'nisn' => $test->nisn,
                'metode' => 'KNN-Absen',
            ], [
                'kategori' => $kategori,
                'sumber' => 'knn',
                'keterangan' => 'Kategori absen diprediksi dengan KNN.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // --------- KNN PELANGGARAN ---------
        $trainingPel = DB::table('rekomendasi_siswa')->where('metode', 'KNN-Pelanggaran')->pluck('nisn');
        $dataTrainPel = DB::table('violations')
            ->join('students', 'students.id', '=', 'violations.student_id')
            ->select('students.nisn', DB::raw('COUNT(*) as jumlah'))
            ->whereIn('students.nisn', $trainingPel)
            ->groupBy('students.nisn')
            ->get();

        $testingPel = $allNisn->diff($trainingPel);
        $dataTestPel = DB::table('violations')
            ->join('students', 'students.id', '=', 'violations.student_id')
            ->select('students.nisn', DB::raw('COUNT(*) as jumlah'))
            ->whereIn('students.nisn', $testingPel)
            ->groupBy('students.nisn')
            ->get();

        foreach ($dataTestPel as $test) {
            $jarak = $dataTrainPel->map(function ($train) use ($test) {
                $kategori = DB::table('rekomendasi_siswa')
                    ->where('nisn', $train->nisn)
                    ->where('metode', 'KNN-Pelanggaran')
                    ->value('kategori');

                return [
                    'nisn' => $train->nisn,
                    'jarak' => abs($train->jumlah - $test->jumlah),
                    'kategori' => $kategori,
                ];
            });

            $kategori = $jarak->sortBy('jarak')->take($k)->groupBy('kategori')->map->count()->sortDesc()->keys()->first();

            DB::table('rekomendasi_siswa')->updateOrInsert([
                'nisn' => $test->nisn,
                'metode' => 'KNN-Pelanggaran',
            ], [
                'kategori' => $kategori,
                'sumber' => 'knn',
                'keterangan' => 'Kategori pelanggaran diprediksi dengan KNN.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Prediksi KNN selesai untuk semua aspek.');
    }


    protected function euclideanDistance(array $a, array $b)
    {
        return sqrt(array_sum(array_map(fn($x, $y) => pow($x - $y, 2), $a, $b)));
    }

    // keputusan akhir knn
    public function keputusanAkhirKNN()
    {
        // Ambil siswa yang sudah memiliki 3 hasil metode KNN
        $siswaList = DB::table('rekomendasi_siswa')
            ->select('nisn')
            ->whereIn('metode', ['KNN-Nilai', 'KNN-Absen', 'KNN-Pelanggaran'])
            ->groupBy('nisn')
            ->havingRaw('COUNT(DISTINCT metode) = 3')
            ->pluck('nisn');

        foreach ($siswaList as $nisn) {
            $kategoriNilai = DB::table('rekomendasi_siswa')
                ->where('nisn', $nisn)
                ->where('metode', 'KNN-Nilai')
                ->value('kategori');

            $kategoriAbsen = DB::table('rekomendasi_siswa')
                ->where('nisn', $nisn)
                ->where('metode', 'KNN-Absen')
                ->value('kategori');

            $kategoriPelanggaran = DB::table('rekomendasi_siswa')
                ->where('nisn', $nisn)
                ->where('metode', 'KNN-Pelanggaran')
                ->value('kategori');

            $votes = collect([$kategoriNilai, $kategoriAbsen, $kategoriPelanggaran])
                ->countBy()
                ->sortDesc();

            $finalKategori = $votes->keys()->first();

            DB::table('rekomendasi_siswa')->updateOrInsert([
                'nisn' => $nisn,
                'metode' => 'Final-KNN',
            ], [
                'kategori' => $finalKategori,
                'sumber' => 'knn',
                'keterangan' => 'Keputusan akhir ditentukan berdasarkan voting KNN dari kategori nilai, absen, dan pelanggaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Keputusan akhir KNN berhasil disimpan.');
    }


    public function klasifikasiBaru(string $nisn)
    {
        $k = 3;

        // ----- KNN NILAI -----
        $fields = ['bindo', 'bing', 'mat', 'ipa', 'ips', 'agama', 'ppkn', 'sosbud', 'tik', 'penjas'];
        $nilaiBaru = DB::table('nilai')->where('nisn', $nisn)->first();
        $trainNilai = DB::table('rekomendasi_siswa')->where('metode', 'KNN-Nilai')->get();

        $kategoriNilai = null;

        if ($nilaiBaru && $trainNilai->count() >= $k) {
            $distNilai = $trainNilai->map(function ($row) use ($fields, $nilaiBaru) {
                $nilaiTrain = DB::table('nilai')->where('nisn', $row->nisn)->first();
                $a = collect($fields)->map(fn($f) => ($nilaiTrain->$f ?? 0) / 100)->toArray();
                $b = collect($fields)->map(fn($f) => ($nilaiBaru->$f ?? 0) / 100)->toArray();
                return [
                    'kategori' => $row->kategori,
                    'jarak' => $this->euclideanDistance($a, $b)
                ];
            });

            $kategoriNilai = $distNilai->sortBy('jarak')
                ->take($k)
                ->groupBy('kategori')
                ->map->count()
                ->sortDesc()
                ->keys()
                ->first();

            if ($kategoriNilai) {
                DB::table('rekomendasi_siswa')->updateOrInsert([
                    'nisn' => $nisn,
                    'metode' => 'KNN-Nilai',
                ], [
                    'kategori' => $kategoriNilai,
                    'sumber' => 'knn',
                    'keterangan' => 'Kategori nilai diprediksi dengan KNN.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ----- KNN ABSEN -----
        $jumlahBaru = DB::table('absensi')
            ->where('nisn', $nisn)
            ->select(DB::raw('SUM(alpa + bolos) as jumlah'))
            ->value('jumlah') ?? 0;

        $trainAbsen = DB::table('rekomendasi_siswa')->where('metode', 'KNN-Absen')->get();
        $kategoriAbsen = null;

        if ($trainAbsen->count() >= $k) {
            $distAbsen = $trainAbsen->map(function ($row) use ($jumlahBaru) {
                $jumlahTrain = DB::table('absensi')
                    ->where('nisn', $row->nisn)
                    ->select(DB::raw('SUM(alpa + bolos) as jumlah'))
                    ->value('jumlah') ?? 0;
                return [
                    'kategori' => $row->kategori,
                    'jarak' => abs($jumlahTrain - $jumlahBaru),
                ];
            });

            $kategoriAbsen = $distAbsen->sortBy('jarak')
                ->take($k)
                ->groupBy('kategori')
                ->map->count()
                ->sortDesc()
                ->keys()
                ->first();

            if ($kategoriAbsen) {
                DB::table('rekomendasi_siswa')->updateOrInsert([
                    'nisn' => $nisn,
                    'metode' => 'KNN-Absen',
                ], [
                    'kategori' => $kategoriAbsen,
                    'sumber' => 'knn',
                    'keterangan' => 'Kategori absen diprediksi dengan KNN.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ----- KNN PELANGGARAN -----
        $poinBaru = DB::table('violations')
            ->join('jenis_pelanggaran', 'jenis_pelanggaran.id', '=', 'violations.jenis_pelanggaran_id')
            ->join('students', 'students.id', '=', 'violations.student_id')
            ->where('students.nisn', $nisn)
            ->sum('jenis_pelanggaran.poin');

        $trainPel = DB::table('rekomendasi_siswa')->where('metode', 'KNN-Pelanggaran')->get();
        $kategoriPel = null;

        if ($trainPel->count() >= $k) {
            $distPel = $trainPel->map(function ($row) use ($poinBaru) {
                $poinTrain = DB::table('violations')
                    ->join('jenis_pelanggaran', 'jenis_pelanggaran.id', '=', 'violations.jenis_pelanggaran_id')
                    ->join('students', 'students.id', '=', 'violations.student_id')
                    ->where('students.nisn', $row->nisn)
                    ->sum('jenis_pelanggaran.poin');

                return [
                    'kategori' => $row->kategori,
                    'jarak' => abs($poinTrain - $poinBaru),
                ];
            });

            $kategoriPel = $distPel->sortBy('jarak')
                ->take($k)
                ->groupBy('kategori')
                ->map->count()
                ->sortDesc()
                ->keys()
                ->first();

            if ($kategoriPel) {
                DB::table('rekomendasi_siswa')->updateOrInsert([
                    'nisn' => $nisn,
                    'metode' => 'KNN-Pelanggaran',
                ], [
                    'kategori' => $kategoriPel,
                    'sumber' => 'knn',
                    'keterangan' => 'Kategori pelanggaran diprediksi dengan KNN.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ----- FINAL VOTING -----
        if ($kategoriNilai && $kategoriAbsen && $kategoriPel) {
            $votes = collect([$kategoriNilai, $kategoriAbsen, $kategoriPel])
                ->countBy()
                ->sortDesc();
            $finalKategori = $votes->keys()->first();

            DB::table('rekomendasi_siswa')->updateOrInsert([
                'nisn' => $nisn,
                'metode' => 'Final-KNN',
            ], [
                'kategori' => $finalKategori,
                'sumber' => 'knn',
                'keterangan' => 'Kategori final hasil voting dari KNN nilai, absen, pelanggaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
