<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Student;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the absensis.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Absensi::with('siswa')->latest();

        // Filter pencarian nama atau NISN
        if ($request->filled('q')) {
            $query->whereHas('siswa', function ($qbuilder) use ($request) {
                $qbuilder->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('nisn', 'like', '%' . $request->q . '%');
            });
        }

        // Filter berdasarkan kelas
        if ($request->filled('class')) {
            $query->whereHas('siswa', function ($qbuilder) use ($request) {
                $qbuilder->where('class', $request->class);
            });
        }

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $bulan = $request->bulan;
            $year = date('Y', strtotime($bulan));
            $month = date('m', strtotime($bulan));

            $query->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year);
        }

        // Perbaikan di sini
        $absensiList = $query->paginate(27);

        // List dropdown
        $classList = Student::select('class')->distinct()->pluck('class');
        $bulanList = Absensi::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as bulan')
            ->distinct()
            ->orderBy('bulan', 'desc')
            ->pluck('bulan');

        return view('guru_bk.absensi.index', compact('absensiList', 'classList', 'bulanList'));
    }


    /**
     * Show the form for creating a new absensi.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ambil semua NISN yang pernah absen (di tabel absensi)
        $nisnYangSudahPernahAbsen = Absensi::pluck('nisn');

        // Ambil siswa yang belum pernah punya data absensi
        $students = Student::whereNotIn('nisn', $nisnYangSudahPernahAbsen)
            ->orderBy('name')
            ->get();

        return view('guru_bk.absensi.create', compact('students'));
    }

    /**
     * Store a newly created absensi in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|exists:students,nisn|unique:absensi,nisn,NULL,id,tanggal,' . $request->tanggal, // Ensure unique NISN for a specific date
            'tanggal' => 'required|date',
            'hadir' => 'nullable|integer|min:0',
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'alpa' => 'nullable|integer|min:0',
            'bolos' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        // Ensure all attendance fields are set to 0 if null
        foreach (['hadir', 'sakit', 'izin', 'alpa', 'bolos'] as $field) {
            $data[$field] = $data[$field] ?? 0;
        }

        Absensi::create($data);

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified absensi.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $absensi = Absensi::findOrFail($id);
        $students = Student::orderBy('name')->get(); // Fetch all students for the dropdown

        return view('guru_bk.absensi.edit', compact('absensi', 'students'));
    }

    /**
     * Update the specified absensi in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);

        $request->validate([
            'nisn' => 'required|exists:students,nisn|unique:absensi,nisn,' . $absensi->id . ',id,tanggal,' . $request->tanggal, // Ensure unique NISN for a specific date, excluding current record
            'tanggal' => 'required|date',
            'hadir' => 'nullable|integer|min:0', // Added validation for these fields
            'sakit' => 'nullable|integer|min:0',
            'izin' => 'nullable|integer|min:0',
            'alpa' => 'nullable|integer|min:0',
            'bolos' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        // Ensure all attendance fields are set to 0 if null
        foreach (['hadir', 'sakit', 'izin', 'alpa', 'bolos'] as $field) {
            $data[$field] = $data[$field] ?? 0;
        }

        $absensi->update($data);

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil diperbarui.');
    }

    /**
     * Remove the specified absensi from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $absensi = Absensi::findOrFail($id);
        $absensi->delete();

        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}
