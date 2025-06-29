<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
   public function index()
    {
        $query = DB::table('nilai')
            ->join('students', 'nilai.nisn', '=', 'students.nisn')
            ->select('nilai.*', 'students.name', 'students.class');

        if (request('kategori')) {
            $query->where('nilai.kategori', request('kategori'));
        }

        if (request('kelas')) {
            $query->where('students.class', request('kelas'));
        }

        if (request('q')) {
            $query->where(function ($q) {
                $q->where('students.name', 'like', '%' . request('q') . '%')
                ->orWhere('nilai.nisn', 'like', '%' . request('q') . '%');
            });
        }

        $data = $query->orderBy('nilai.kategori')
                    ->orderByDesc('nilai.rata_rata')
                    ->paginate(20)
                    ->appends(request()->query());

        $semuaKelas = DB::table('students')
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        return view('guru_bk.nilai.index', compact('data', 'semuaKelas'));
    }


    public function edit($id)
    {
        $nilai = DB::table('nilai')->where('id', $id)->first();
        if (!$nilai) abort(404);

        // Ambil data siswa berdasarkan nisn
        $siswa = DB::table('students')
            ->where('nisn', $nilai->nisn)
            ->select('name', 'class')
            ->first();

        return view('guru_bk.nilai.edit', compact('nilai', 'siswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nisn' => 'required|string|max:20',
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

        $mapel = $request->only([
            'bindo', 'bing', 'mat', 'ipa', 'ips', 'agama',
            'ppkn', 'sosbud', 'tik', 'penjas'
        ]);

        $jumlah = array_sum($mapel);
        $rata = $jumlah / count($mapel);

        if ($rata >= 85) {
            $kategori = 'Baik';
        } elseif ($rata >= 75) {
            $kategori = 'Cukup';
        } else {
            $kategori = 'Butuh Bimbingan';
        }

        $data = array_merge(
            ['nisn' => $request->nisn],
            $mapel,
            [
                'jumlah_nilai' => $jumlah,
                'rata_rata' => $rata,
                'kategori' => $kategori,
            ]
        );

        DB::table('nilai')->where('id', $id)->update($data);

        return redirect()->route('nilai.index')->with('success', 'Nilai siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('nilai')->where('id', $id)->delete();

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus.');
    }
}
