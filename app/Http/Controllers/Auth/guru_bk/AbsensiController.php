<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with('siswa')->latest();

        if ($request->filled('q')) {
            $query->whereHas('siswa', function ($qbuilder) use ($request) {
                $qbuilder->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('nisn', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('class')) {
            $query->whereHas('siswa', function ($qbuilder) use ($request) {
                $qbuilder->where('class', $request->class);
            });
        }

        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            $year = date('Y', strtotime($bulan));
            $month = date('m', strtotime($bulan));

            $query->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year);
        }

        $absensiList = $query->paginate(27);

        $classList = Student::select('class')->distinct()->pluck('class');
        $bulanList = Absensi::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as bulan')
            ->distinct()
            ->orderBy('bulan', 'desc')
            ->pluck('bulan');

        return view('guru_bk.absensi.index', compact('absensiList', 'classList', 'bulanList'));
    }

    public function create()
    {
        $nisnYangSudahPernahAbsen = Absensi::pluck('nisn');

        $students = Student::whereNotIn('nisn', $nisnYangSudahPernahAbsen)
            ->orderBy('name')
            ->get();

        return view('guru_bk.absensi.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|exists:students,nisn|unique:absensi,nisn,NULL,id,tanggal,' . $request->tanggal,
            'tanggal' => 'required|date',
            'hadir' => 'nullable|integer|min:0',
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'alpa' => 'nullable|integer|min:0',
            'bolos' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        foreach (['hadir', 'sakit', 'izin', 'alpa', 'bolos'] as $field) {
            $data[$field] = $data[$field] ?? 0;
        }

        Absensi::create($data);

        // 🚩 Tandai agar siswa ini diproses oleh KNN
        DB::table('students')->where('nisn', $request->nisn)->update([
            'is_predicted' => false,
        ]);

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $students = Student::orderBy('name')->get();

        return view('guru_bk.absensi.edit', compact('absensi', 'students'));
    }

    public function update(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);

        $request->validate([
            'nisn' => 'required|exists:students,nisn|unique:absensi,nisn,' . $absensi->id . ',id,tanggal,' . $request->tanggal,
            'tanggal' => 'required|date',
            'hadir' => 'nullable|integer|min:0',
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'alpa' => 'nullable|integer|min:0',
            'bolos' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        foreach (['hadir', 'sakit', 'izin', 'alpa', 'bolos'] as $field) {
            $data[$field] = $data[$field] ?? 0;
        }

        $absensi->update($data);

        // 🚩 Tandai agar siswa ini diproses ulang oleh KNN
        DB::table('students')->where('nisn', $request->nisn)->update([
            'is_predicted' => false,
        ]);

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil diperbarui.');
    }
}
