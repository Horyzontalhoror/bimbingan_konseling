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

    public function edit($id)
    {
        $nilai = DB::table('nilai')->where('id', $id)->first();
        if (!$nilai) {
            abort(404);
        }

        return view('guru_bk.nilai.edit', compact('nilai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|max:20',
            'class' => 'required|string|max:20',
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

        // Ambil semua nilai pelajaran
        $mapel = $request->only([
            'bindo', 'bing', 'mat', 'ipa', 'ips', 'agama',
            'ppkn', 'sosbud', 'tik', 'penjas'
        ]);

        // Hitung ulang jumlah dan rata-rata
        $jumlah = array_sum($mapel);
        $rata = $jumlah / count($mapel);

        // Tentukan kategori
        if ($rata >= 85) {
            $kategori = 'Baik';
        } elseif ($rata >= 75) {
            $kategori = 'Cukup';
        } else {
            $kategori = 'Butuh Bimbingan';
        }

        // Gabungkan semua data
        $data = array_merge(
            $request->only(['name', 'nisn', 'class']),
            $mapel,
            [
                'jumlah_nilai' => $jumlah,
                'rata_rata' => $rata,
                'kategori' => $kategori,
            ]
        );

        DB::table('nilai')->where('id', $id)->update($data);

        return redirect()->route('nilai.index')->with('success', 'Nilai siswa berhasil diperbarui.');
        dd($request->all());
    }

    public function destroy($id)
    {
        DB::table('nilai')->where('id', $id)->delete();

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus.');
    }
}
