<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class KonfigurasiKMeansController extends Controller
{
    // Show the configuration of KMeans.
    public function index()
    {
        $data = DB::table('konfigurasi_kmeans')
            ->orderBy('id')
            ->get();

        $konfigurasiKMeans = DB::table('konfigurasi_kmeans')
            ->orderBy('tipe')
            ->orderBy('nama_centroid')
            ->get();

        return view('guru_bk.konfig.index', compact('data', 'konfigurasiKMeans'));
    }

    public function edit($id)
    {
        $nilai = DB::table('konfigurasi_kmeans')->where('id', $id)->first();

        if (!$nilai) {
            return redirect()->route('konfig.index')->with('error', 'Data tidak ditemukan.');
        }

        $nama = $nilai->nama_centroid;

        $data = DB::table('konfigurasi_kmeans')
            ->where('nama_centroid', $nama)
            ->get()
            ->keyBy('tipe'); // tipe: nilai, absen, pelanggaran

        return view('guru_bk.konfig.edit', compact('data'));
    }

    public function update($id)
    {
        request()->validate([
            'nilai_centroid' => 'required|numeric',
            'absen_centroid' => 'required|numeric',
            'pelanggaran_centroid' => 'required|numeric',
        ]);

        $centroid = DB::table('konfigurasi_kmeans')->where('id', $id)->first();

        if (!$centroid) {
            return redirect()->route('konfigurasi.index')->with('error', 'Data tidak ditemukan.');
        }

        $nama = $centroid->nama_centroid;

        // Update centroid untuk semua tipe
        DB::table('konfigurasi_kmeans')->where('nama_centroid', $nama)->where('tipe', 'nilai')
            ->update(['centroid' => request('nilai_centroid'), 'updated_at' => now()]);

        DB::table('konfigurasi_kmeans')->where('nama_centroid', $nama)->where('tipe', 'absen')
            ->update(['centroid' => request('absen_centroid'), 'updated_at' => now()]);

        DB::table('konfigurasi_kmeans')->where('nama_centroid', $nama)->where('tipe', 'pelanggaran')
            ->update(['centroid' => request('pelanggaran_centroid'), 'updated_at' => now()]);

        return redirect()->route('konfigurasi.index')->with('success', 'Centroid berhasil diperbarui.');
    }
}
