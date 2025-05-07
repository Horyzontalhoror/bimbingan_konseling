<?php

namespace App\Http\Controllers\Auth\guru_bk;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

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

        $students = $query->latest()->paginate(20)->appends(request()->query());

        // Ambil semua kelas unik
        $semuaKelas = Student::select('class')->distinct()->orderBy('class')->pluck('class');

        return view('guru_bk.students.index', compact('students', 'semuaKelas'));
    }


    public function create()
    {
        return view('guru_bk.students.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|unique:students,nisn',
            'class' => 'required|string',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
        ]);
        Student::create($request->only([
            'name', 'nisn', 'class', 'gender', 'address', 'birth_date'
        ]));
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

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
            'gender' => 'required|in:Laki-laki,Perempuan',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
        ]);
        $student->update($request->only([
            'name', 'nisn', 'class', 'gender', 'address', 'birth_date'
        ]));
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
