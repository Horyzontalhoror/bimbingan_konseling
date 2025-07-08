<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Models\KonfigurasiKMeans;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AlgoritmaController extends Controller
{
    public function index()
    {
        // Hasil clustering KMeans dari tabel rekomendasi_siswa
        $kmeansResults = DB::table('rekomendasi_siswa')
            ->join('students', 'rekomendasi_siswa.nisn', '=', 'students.nisn')
            ->select('students.name', 'students.class', 'students.nisn', 'rekomendasi_siswa.kategori as cluster')
            ->where('rekomendasi_siswa.metode', 'KMeans-Nilai')
            ->orderBy('cluster')
            ->get();

        // Hasil prediksi KNN
        $knnResults = DB::table('rekomendasi_siswa')
            ->join('students', 'rekomendasi_siswa.nisn', '=', 'students.nisn')
            ->select('students.name', 'students.class', 'students.nisn', 'rekomendasi_siswa.kategori as prediksi')
            ->where('rekomendasi_siswa.metode', 'KNN')
            ->get();

        // Semua data rekomendasi
        $rekomendasi = DB::table('rekomendasi_siswa')
            ->join('students', 'rekomendasi_siswa.nisn', '=', 'students.nisn')
            ->select('rekomendasi_siswa.*', 'students.name', 'students.class')
            ->get();

        return view('guru_bk.algoritma.index', compact('kmeansResults', 'knnResults', 'rekomendasi'));
    }

    /**
     * Show the form for editing the specified KMeans configuration.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $konfigurasi = KonfigurasiKMeans::findOrFail($id);
        return view('guru_bk.algoritma.kmeans.edit', compact('konfigurasi'));
    }

    /**
     * Update the specified KMeans configuration in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    // Update method to handle the form submission for editing KMeans configuration
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_centroid' => 'required|string|max:100',
            'nilai_centroid' => 'required|numeric',
            'kategori' => 'required|in:Baik,Cukup,Butuh Bimbingan',
        ]);

        $konfigurasi = KonfigurasiKMeans::findOrFail($id);
        $konfigurasi->update([
            'nama_centroid' => $request->nama_centroid,
            'nilai_centroid' => $request->nilai_centroid,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('algoritma.index')->with('success', 'Konfigurasi centroid berhasil diperbarui.');
    }

    /**
     * Reset KNN categories and predictions.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetKategori()
    {
        DB::table('rekomendasi_siswa')
            ->whereIn('kategori', [
                'Rajin',
                'Cukup',
                'Sering Absen',
                'Butuh Bimbingan',
                'Baik',
                'Tidak Pernah',
                'Ringan',
                'Sering'
            ])
            ->delete();

        return redirect()->route('algoritma.index')->with('success', 'Berhasil direset.');
    }
}
