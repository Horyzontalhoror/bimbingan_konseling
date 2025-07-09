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

        if (request('q')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request('q') . '%')
                    ->orWhere('nisn', 'like', '%' . request('q') . '%');
            });
        }

        if (request('kelas')) {
            $query->where('class', request('kelas'));
        }

        $students = $query->latest()->paginate(27)->appends(request()->query());
        $semuaKelas = Student::select('class')->distinct()->orderBy('class')->pluck('class');

        return view('guru_bk.students.index', compact('students', 'semuaKelas'));
    }

    public function create()
    {
        $jenisPelanggaran = JenisPelanggaran::all();
        return view('guru_bk.students.create', compact('jenisPelanggaran'));
    }

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
            // Tambahkan flag is_predicted ke false agar diproses oleh KNN
            Student::create(array_merge(
                $request->only(['name', 'nisn', 'class']),
                ['is_predicted' => false]
            ));

            // Simpan nilai
            $nilaiData = $request->nilai ?? [];
            Nilai::create(array_merge($nilaiData, [
                'nisn' => $nisn,
                'jumlah_nilai' => array_sum($nilaiData),
                'rata_rata' => count($nilaiData) ? round(array_sum($nilaiData) / count($nilaiData), 2) : 0,
            ]));

            // Simpan absensi
            Absensi::create(array_merge($request->absensi ?? [], [
                'nisn' => $nisn,
                'tanggal' => now(),
            ]));

            // Simpan pelanggaran (jika ada)
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

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit(Student $student)
    {
        return view('guru_bk.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:students,nisn,' . $student->id,
            'class' => 'required|string|max:20',
        ]);

        $student->update($request->only(['name', 'nisn', 'class']));

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
