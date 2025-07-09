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

        if (request()->filled('kelas')) {
            $query->where('students.class', request('kelas'));
        }

        if (request()->filled('q')) {
            $query->where(function ($q) {
                $q->where('students.name', 'like', '%' . request('q') . '%')
                    ->orWhere('students.nisn', 'like', '%' . request('q') . '%');
            });
        }

        $data = $query->orderByDesc('nilai.updated_at')
            ->paginate(27)
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
        if (!$nilai) abort(404, 'Data nilai tidak ditemukan.');

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
            'bindo' => 'required|numeric|min:0|max:100',
            'bing' => 'required|numeric|min:0|max:100',
            'mat' => 'required|numeric|min:0|max:100',
            'ipa' => 'required|numeric|min:0|max:100',
            'ips' => 'required|numeric|min:0|max:100',
            'agama' => 'required|numeric|min:0|max:100',
            'ppkn' => 'required|numeric|min:0|max:100',
            'sosbud' => 'required|numeric|min:0|max:100',
            'tik' => 'required|numeric|min:0|max:100',
            'penjas' => 'required|numeric|min:0|max:100',
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

        $data = array_merge(
            ['nisn' => $request->nisn],
            $mapel,
            [
                'jumlah_nilai' => $jumlah,
                'rata_rata'    => $rata,
            ]
        );

        DB::table('nilai')->where('id', $id)->update($data);

        // 🚩 Tandai siswa agar diproses ulang oleh KNN
        DB::table('students')->where('nisn', $request->nisn)->update([
            'is_predicted' => false,
        ]);

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
