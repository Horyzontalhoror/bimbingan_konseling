<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use App\Models\Student;
use App\Models\JenisPelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViolationController extends Controller
{
    /**
     * Menampilkan daftar semua pelanggaran.
     */
    public function index()
    {
        // Ambil semua data pelanggaran dengan relasi student dan jenis pelanggaran
        $violations = Violation::with(['student', 'jenis'])
            ->orderByDesc('date')
            ->get();

        // Hitung siswa dengan poin pelanggaran tertinggi
        $poinTertinggi = DB::table('violations')
            ->join('students', 'violations.nisn', '=', 'students.nisn')
            ->join('jenis_pelanggaran', 'violations.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->select('students.name', DB::raw('SUM(jenis_pelanggaran.poin) as total_poin'))
            ->groupBy('violations.nisn', 'students.name')
            ->orderByDesc('total_poin')
            ->first();

        return view('guru_bk.violations.index', compact('violations', 'poinTertinggi'));
    }



    /**
     * Menampilkan form untuk membuat pelanggaran baru.
     */
    public function create()
    {
        // Tidak ada perubahan, sudah bagus.
        $students = Student::orderBy('name')->get();
        $jenisPelanggaran = JenisPelanggaran::orderBy('nama')->get();

        return view('guru_bk.violations.create', compact('students', 'jenisPelanggaran'));
    }

    /**
     * Menyimpan data pelanggaran baru ke database.
     */
    public function store(Request $request)
    {
        // Menggunakan hasil validasi untuk membuat data (lebih aman dan bersih)
        $validatedData = $request->validate([
            'student_id' => 'required|exists:students,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'action' => 'nullable|string|max:255',
        ]);

        Violation::create($validatedData);

        return redirect()->route('violations.index')
            ->with('success', 'Catatan pelanggaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data pelanggaran.
     */
    public function edit(Violation $violation)
    {
        // Tidak ada perubahan, sudah menggunakan route-model binding dengan baik.
        // Relasi sudah di-load otomatis oleh Laravel.
        $students = Student::orderBy('name')->get();
        $jenisPelanggaran = JenisPelanggaran::orderBy('nama')->get();

        return view('guru_bk.violations.edit', compact('violation', 'students', 'jenisPelanggaran'));
    }

    /**
     * Memperbarui data pelanggaran di database.
     */
    public function update(Request $request, Violation $violation)
    {
        $validatedData = $request->validate([
            'nisn' => 'required|exists:students,nisn',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'action' => 'nullable|string|max:255',
        ]);

        $violation->update($validatedData);

        return redirect()->route('violations.index')
            ->with('success', 'Data pelanggaran berhasil diperbarui.');
    }


    /**
     * Menghapus data pelanggaran dari database.
     */
    public function destroy(Violation $violation)
    {
        // Tidak ada perubahan, sudah bagus.
        $violation->delete();

        return redirect()->route('violations.index')
            ->with('success', 'Data pelanggaran berhasil dihapus.');
    }
}
