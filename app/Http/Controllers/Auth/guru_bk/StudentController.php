<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Nilai;
use App\Models\Absensi;
use App\Models\JenisPelanggaran;
use App\Models\Violation;

class StudentController extends Controller
{
    public function index()
    {
        $query = Student::query();

        // Filter berdasarkan kata kunci
        if (request('q')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request('q') . '%')
                    ->orWhere('nisn', 'like', '%' . request('q') . '%');
            });
        }

        // Filter berdasarkan kelas
        if (request('kelas')) {
            $query->where('class', request('kelas'));
        }

        $students = $query->latest()->paginate(27)->appends(request()->query());

        // Ambil semua kelas unik
        $semuaKelas = Student::select('class')->distinct()->orderBy('class')->pluck('class');

        return view('guru_bk.students.index', compact('students', 'semuaKelas'));
    }

    // create data baru
    public function create()
    {
        $jenisPelanggaran = JenisPelanggaran::all();
        return view('guru_bk.students.create', compact('jenisPelanggaran'));
    }

    // store
    public function store(Request $request)
    {
        $nisn = $request->nisn;
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|unique:students,nisn',
            'class' => 'required|string|max:255',
            'nilai.*' => 'required|numeric|min:0|max:100',
            'absensi.*' => 'required|integer|min:0',
            'pelanggaran.*.jenis_id' => 'nullable|exists:jenis_pelanggaran,id',
            'pelanggaran.*.tanggal' => 'nullable|date',
            'pelanggaran.*.keterangan' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $nisn) {
            // Simpan siswa
            Student::create($request->only(['name', 'nisn', 'class']));

            // Simpan nilai
            $nilaiData = $request->nilai ?? [];
            \App\Models\Nilai::create(array_merge($nilaiData, [
                'nisn' => $nisn,
                'jumlah_nilai' => array_sum($nilaiData),
                'rata_rata' => count($nilaiData) ? round(array_sum($nilaiData) / count($nilaiData), 2) : 0,
            ]));

            // Simpan absensi
            \App\Models\Absensi::create(array_merge($request->absensi ?? [], [
                'nisn' => $nisn,
                'tanggal' => now(),
            ]));

            // Simpan pelanggaran
            foreach ($request->pelanggaran ?? [] as $p) {
                if (!empty($p['jenis_id'])) {
                    Violation::create([
                        'nisn' => $nisn,
                        'jenis_pelanggaran_id' => $p['jenis_id'],
                        'date' => $p['tanggal'] ?? now(),
                        'description' => $p['keterangan'] ?? null,
                        'action' => null,
                    ]);
                }
            }
        });

        // Cek referensi KMeans tersedia
        $count = DB::table('rekomendasi_siswa')->where('metode', 'like', 'KMeans%')->count();
        if ($count < 3) {
            return redirect()->route('students.index')
                ->with('error', 'Data referensi KMeans belum tersedia. Jalankan KMeans terlebih dahulu.');
        }

        // Jalankan KNN
        if (is_string($nisn) && !empty($nisn)) {
            app(\App\Http\Controllers\Auth\guru_bk\KNNController::class)->klasifikasiBaru($nisn);
        }

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil ditambahkan dan diklasifikasi.');
    }

    // edit
    public function edit(Student $student)
    {
        return view('guru_bk.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:students,nisn,' . $student->id,
            'class' => 'required|string|max:20',
        ]);
        $student->update($request->only([
            'name',
            'nisn',
            'class'
        ]));
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
