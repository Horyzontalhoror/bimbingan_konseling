<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon; // Pastikan ini di-import untuk penggunaan Carbon::now()

class KMeansController extends Controller
{
    // --- Konstanta untuk Kategori dan Metode ---
    // Mendefinisikan string literal sebagai konstanta adalah praktik terbaik
    // untuk meningkatkan keterbacaan, mengurangi kesalahan ketik, dan mempermudah pemeliharaan.

    // Kategori Hasil Rekomendasi / Kategori Nilai Siswa
    const KATEGORI_BUTUH_BIMBINGAN = 'Butuh Bimbingan';
    const KATEGORI_CUKUP = 'Cukup';
    const KATEGORI_BAIK = 'Baik';

    // Kategori Absensi Siswa
    const KATEGORI_ABSEN_SERING = 'Sering Absen';
    const KATEGORI_ABSEN_CUKUP = 'Cukup';
    const KATEGORI_ABSEN_JARANG = 'Jarang Absen'; // Asumsi ada kategori ini

    // Kategori Pelanggaran Siswa
    const KATEGORI_PELANGGARAN_SERING = 'Sering';
    const KATEGORI_PELANGGARAN_RINGAN = 'Ringan';
    const KATEGORI_PELANGGARAN_TIDAK_ADA = 'Tidak Ada'; // Asumsi ada kategori ini

    // Metode Pengambilan Data dari Tabel 'rekomendasi_siswa'
    const METODE_KMEANS_NILAI = 'KMeans-Nilai';
    const METODE_KMEANS_ABSEN = 'KMeans-Absen';
    const METODE_KMEANS_PELANGGARAN = 'KMeans-Pelanggaran';
    const METODE_FINAL = 'Final';
    const SUMBER_FINAL = 'final';

    /**
     * Menentukan keputusan akhir rekomendasi untuk setiap siswa
     * berdasarkan kategori nilai akademik, kehadiran, dan pelanggaran.
     *
     * Fungsi ini bertujuan untuk meningkatkan akurasi penentuan kategori siswa.
     * Dengan mempertimbangkan tiga aspek sekaligus, guru dapat mengambil keputusan
     * yang lebih spesifik dan adil, serta memahami faktor utama yang mempengaruhi
     * hasil akhir, sehingga keputusan yang diambil tidak hanya berdasarkan satu aspek saja.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function keputusanAkhir()
    {
        $data = DB::table('students')
            ->leftJoin('rekomendasi_siswa as knilai', function ($q) {
                $q->on('students.nisn', '=', 'knilai.nisn')->where('knilai.metode', 'KNN-Nilai');
            })
            ->leftJoin('rekomendasi_siswa as kknilai', function ($q) {
                $q->on('students.nisn', '=', 'kknilai.nisn')->where('kknilai.metode', 'KMeans-Nilai');
            })
            ->leftJoin('rekomendasi_siswa as kabsen', function ($q) {
                $q->on('students.nisn', '=', 'kabsen.nisn')->where('kabsen.metode', 'KMeans-Absen');
            })
            ->leftJoin('rekomendasi_siswa as knabsen', function ($q) {
                $q->on('students.nisn', '=', 'knabsen.nisn')->where('knabsen.metode', 'KNN-Absen');
            })
            ->leftJoin('rekomendasi_siswa as kpel', function ($q) {
                $q->on('students.nisn', '=', 'kpel.nisn')->where('kpel.metode', 'KMeans-Pelanggaran');
            })
            ->leftJoin('rekomendasi_siswa as knpel', function ($q) {
                $q->on('students.nisn', '=', 'knpel.nisn')->where('knpel.metode', 'KNN-Pelanggaran');
            })
            ->select(
                'students.nisn',
                DB::raw('COALESCE(kknilai.kategori, knilai.kategori) as kategori_nilai'),
                DB::raw('COALESCE(kabsen.kategori, knabsen.kategori) as kategori_absen'),
                DB::raw('COALESCE(kpel.kategori, knpel.kategori) as kategori_pelanggaran')
            )
            ->get();

        $recordsToUpsert = [];
        $timestamp = now();

        foreach ($data as $row) {
            $nisn = $row->nisn;
            $nilai = $row->kategori_nilai ?? '-';
            $absen = $row->kategori_absen ?? '-';
            $pel = $row->kategori_pelanggaran ?? '-';

            $final = self::KATEGORI_BAIK;

            if (
                $nilai === self::KATEGORI_BUTUH_BIMBINGAN ||
                $absen === self::KATEGORI_ABSEN_SERING ||
                $pel === self::KATEGORI_PELANGGARAN_SERING
            ) {
                $final = self::KATEGORI_BUTUH_BIMBINGAN;
            } elseif (
                $nilai === self::KATEGORI_CUKUP ||
                $absen === self::KATEGORI_ABSEN_CUKUP ||
                $pel === self::KATEGORI_PELANGGARAN_RINGAN
            ) {
                $final = self::KATEGORI_CUKUP;
            }

            $keterangan = "Kategori akhir dari kombinasi (Nilai: $nilai, Absen: $absen, Pelanggaran: $pel)";

            $exists = DB::table('rekomendasi_siswa')
                ->where('nisn', $nisn)
                ->where('metode', self::METODE_FINAL)
                ->exists();

            $record = [
                'nisn' => $nisn,
                'metode' => self::METODE_FINAL,
                'kategori' => $final,
                'sumber' => self::SUMBER_FINAL,
                'keterangan' => $keterangan,
                'updated_at' => $timestamp,
            ];

            if (!$exists) {
                $record['created_at'] = $timestamp;
            }

            $recordsToUpsert[] = $record;
        }

        if (!empty($recordsToUpsert)) {
            DB::table('rekomendasi_siswa')->upsert(
                $recordsToUpsert,
                ['nisn', 'metode'],
                ['kategori', 'sumber', 'keterangan', 'updated_at']
            );
        }

        // 🔒 Tandai bahwa semua proses K-Means sudah dikunci
        session()->put('kmeans.completed', true);

        return back()->with('success', 'Keputusan akhir berhasil ditentukan dengan data gabungan KMeans dan KNN.');
    }
}
