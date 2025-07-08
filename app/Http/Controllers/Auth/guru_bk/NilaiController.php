<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function index()
    {
        $query = DB::table('students')
            ->leftJoin('nilai', 'students.nisn', '=', 'nilai.nisn')
            ->select('nilai.*', 'students.name', 'students.class', 'students.nisn');

        // Hapus filter kategori karena kolom nilai.kategori sudah tidak ada
        // if (request()->filled('kategori')) {
        //     $query->where('nilai.kategori', request('kategori'));
        // }

        if (request()->filled('kelas')) {
            $query->where('students.class', request('kelas'));
        }

        if (request()->filled('q')) {
            $query->where(function ($q) {
                $q->where('students.name', 'like', '%' . request('q') . '%')
                    ->orWhere('students.nisn', 'like', '%' . request('q') . '%');
            });
        }

        // Hapus orderBy berdasarkan kategori
        $data = $query->orderByDesc('nilai.rata_rata')
            ->paginate(27)
            ->appends(request()->query());

        $semuaKelas = DB::table('students')
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
        if (!$nilai) abort(404);

        $siswa = DB::table('students')
            ->where('nisn', $nilai->nisn)
            ->select('name', 'class')
            ->first();

        return view('guru_bk.nilai.edit', compact('nilai', 'siswa'));
    }

    // update
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

        $nilai = DB::table('nilai')->where('id', $id)->first();
        if (!$nilai) {
            return redirect()->route('nilai.index')->with('error', 'Data nilai tidak ditemukan.');
        }

        $mapel = $request->only([
            'bindo',
            'bing',
            'mat',
            'ipa',
            'ips',
            'agama',
            'ppkn',
            'sosbud',
            'tik',
            'penjas'
        ]);

        $jumlah = array_sum($mapel);
        $rata = round($jumlah / count($mapel), 2);

        $kategori = match (true) {
            $rata >= 85 => 'Baik',
            $rata >= 75 => 'Cukup',
            default     => 'Butuh Bimbingan'
        };

        $data = array_merge(
            ['nisn' => $request->nisn],
            $mapel,
            [
                'jumlah_nilai' => $jumlah,
                'rata_rata'    => $rata,
            ]
        );

        DB::table('nilai')->where('id', $id)->update($data);

        return redirect()->route('nilai.index')->with('success', 'Nilai siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nilai = DB::table('nilai')->where('id', $id)->first();
        if (!$nilai) {
            return redirect()->route('nilai.index')->with('error', 'Data nilai tidak ditemukan.');
        }

        DB::table('nilai')->where('id', $id)->delete();

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus.');
    }
}
