<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $kategori = request()->input('kategori');
        $kelas = request()->input('kelas');
        $search = trim(request()->input('q'));

        $query = DB::table('students')
            ->leftJoin(DB::raw("(
            SELECT nisn, kategori FROM (
                SELECT *, ROW_NUMBER() OVER (
                    PARTITION BY nisn ORDER BY FIELD(metode, 'KNN-Nilai', 'KMeans-Nilai')
                ) AS rn
                FROM rekomendasi_siswa
                WHERE metode IN ('KNN-Nilai', 'KMeans-Nilai')
                ) AS ranked_nilai
                WHERE rn = 1
            ) as nilai"), 'students.nisn', '=', 'nilai.nisn')

            ->leftJoin(DB::raw("(
            SELECT nisn, kategori FROM (
                SELECT *, ROW_NUMBER() OVER (
                    PARTITION BY nisn ORDER BY FIELD(metode, 'KNN-Absen', 'KMeans-Absen')
                ) AS rn
                FROM rekomendasi_siswa
                WHERE metode IN ('KNN-Absen', 'KMeans-Absen')
                ) AS ranked_absen
                WHERE rn = 1
            ) as absen"), 'students.nisn', '=', 'absen.nisn')

            ->leftJoin(DB::raw("(
            SELECT nisn, kategori FROM (
                SELECT *, ROW_NUMBER() OVER (
                    PARTITION BY nisn ORDER BY FIELD(metode, 'KNN-Pelanggaran', 'KMeans-Pelanggaran')
                ) AS rn
                FROM rekomendasi_siswa
                WHERE metode IN ('KNN-Pelanggaran', 'KMeans-Pelanggaran')
                ) AS ranked_pelanggaran
                WHERE rn = 1
            ) as pelanggaran"), 'students.nisn', '=', 'pelanggaran.nisn')

            ->leftJoin('rekomendasi_siswa as final', function ($q) {
                $q->on('students.nisn', '=', 'final.nisn')->where('final.metode', '=', 'Final');
            })

            ->select(
                // 'students.id',
                'students.name',
                'students.nisn',
                'students.class',
                DB::raw('COALESCE(nilai.kategori, "-") as nilai'),
                DB::raw('COALESCE(absen.kategori, "-") as absen'),
                DB::raw('COALESCE(pelanggaran.kategori, "-") as pelanggaran'),
                DB::raw('COALESCE(final.kategori, "-") as final')
            );

        if ($kategori) {
            $query->where('final.kategori', $kategori);
        }

        if ($kelas) {
            $query->where('students.class', $kelas);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('students.name', 'like', "%{$search}%")
                    ->orWhere('students.nisn', 'like', "%{$search}%");
            });
        }

        $query->orderByRaw("
        FIELD(
            CONCAT_WS('-', nilai.kategori, absen.kategori, pelanggaran.kategori),
            'Butuh Bimbingan-Sering Absen-Sering',
            'Butuh Bimbingan-Sering Absen-Ringan',
            'Butuh Bimbingan-Sering Absen-Tidak Pernah',
            'Butuh Bimbingan-Cukup-Sering',
            'Butuh Bimbingan-Cukup-Ringan',
            'Butuh Bimbingan-Cukup-Tidak Pernah',
            'Butuh Bimbingan-Rajin-Sering',
            'Butuh Bimbingan-Rajin-Ringan',
            'Butuh Bimbingan-Rajin-Tidak Pernah',
            'Cukup-Sering Absen-Sering',
            'Cukup-Sering Absen-Ringan',
            'Cukup-Sering Absen-Tidak Pernah',
            'Cukup-Cukup-Sering',
            'Cukup-Cukup-Ringan',
            'Cukup-Cukup-Tidak Pernah',
            'Cukup-Rajin-Sering',
            'Cukup-Rajin-Ringan',
            'Cukup-Rajin-Tidak Pernah',
            'Baik-Sering Absen-Sering',
            'Baik-Sering Absen-Ringan',
            'Baik-Sering Absen-Tidak Pernah',
            'Baik-Cukup-Sering',
            'Baik-Cukup-Ringan',
            'Baik-Cukup-Tidak Pernah',
            'Baik-Rajin-Sering',
            'Baik-Rajin-Ringan',
            'Baik-Rajin-Tidak Pernah'
        )
    ");

        $siswa = $query->paginate(20)->appends(request()->query());

        $semuaKelas = DB::table('students')
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        $statistik = DB::table('rekomendasi_siswa')
            ->where('metode', 'Final')
            ->select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->get();

        return view('guru_bk.dashboard.dashboard', compact('siswa', 'semuaKelas', 'statistik'));
    }

    public function detail($type, $nisn)
    {
        $mapping = [
            'nilai' => 'nilai',
            'absen' => 'absensi',
            'pelanggaran' => 'violations',
        ];

        if (!array_key_exists($type, $mapping)) {
            return response()->json(['html' => '<p class="text-danger">Tipe tidak valid.</p>']);
        }

        $tableName = $mapping[$type];

        if ($type === 'pelanggaran') {
            $rows = DB::table('violations')
                ->leftJoin('jenis_pelanggaran', 'violations.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
                ->select('violations.*')
                ->where('violations.nisn', $nisn)
                ->get();
        } else {
            $rows = DB::table($tableName)->where('nisn', $nisn)->get();
        }

        if ($rows->isEmpty()) {
            return response()->json(['html' => "<p class='text-muted'>Data tidak ditemukan untuk NISN: $nisn</p>"]);
        }

        $html = '<table class="table table-bordered">';
        foreach ($rows as $row) {
            $html .= '<tr><td colspan="2" class="bg-light font-weight-bold text-primary"># ' . ($row->id ?? '-') . '</td></tr>';
            foreach ($row as $key => $value) {
                if (in_array($key, ['created_at', 'updated_at','id'])) continue;

                $label = $key === 'jenis_pelanggaran_nama' ? 'Jenis Pelanggaran' : $key;
                $html .= "<tr><th>{$label}</th><td>{$value}</td></tr>";
            }
            $html .= '<tr><td colspan="2" class="table-secondary"></td></tr>';
        }
        $html .= '</table>';

        return response()->json(['html' => $html]);
    }
}
