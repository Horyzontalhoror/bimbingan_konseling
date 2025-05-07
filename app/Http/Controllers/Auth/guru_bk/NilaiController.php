<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function index()
    {
        $query = DB::table('nilai');

        // Terapkan filter jika ada
        if (request('kategori')) {
            $query->where('kategori', request('kategori'));
        }

        if (request('kelas')) {
            $query->where('class', request('kelas'));
        }

        if (request('q')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request('q') . '%')
                  ->orWhere('nisn', 'like', '%' . request('q') . '%');
            });
        }

        $data = $query->orderBy('kategori')
                      ->orderByDesc('rata_rata')
                      ->paginate(20)
                      ->appends(request()->query());

        // Ambil semua kelas unik
        $semuaKelas = DB::table('nilai')
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        return view('guru_bk.nilai.index', compact('data', 'semuaKelas'));
    }
    // edit
    public function edit($id)
    {
        $nilai = DB::table('nilai')->where('id', $id)->first();

        return view('guru_bk.nilai.edit', compact('nilai'));
    }

    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'bindo' => 'required|numeric',
            'bing' => 'required|numeric',
            'mat' => 'required|numeric',
            'ipa' => 'required|numeric',
            'ips' => 'required|numeric',
            'agama' => 'required|numeric',
            'ppkn' => 'required|numeric',
            'sosbud' => 'required|numeric',
            'tik' => 'required|numeric',
            'penjas' => 'required|numeric',
        ]);

        $data = $request->only(['bindo', 'bing', 'mat', 'ipa', 'ips', 'agama', 'ppkn', 'sosbud', 'tik', 'penjas']);

        // Hitung ulang jumlah & rata-rata
        $jumlah = array_sum($data);
        $rata = $jumlah / count($data);

        $data['jumlah_nilai'] = $jumlah;
        $data['rata_rata'] = $rata;

        // Update kategori
        if ($rata >= 85) {
            $data['kategori'] = 'Baik';
        } elseif ($rata >= 70) {
            $data['kategori'] = 'Cukup';
        } else {
            $data['kategori'] = 'Butuh Bimbingan';
        }

        DB::table('nilai')->where('id', $id)->update($data);

        return redirect()->route('nilai.index')->with('success', 'Nilai siswa berhasil diperbarui.');
    }

    // destroy
    public function destroy($id)
    {
        DB::table('nilai')->where('id', $id)->delete();

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus.');
    }
}
