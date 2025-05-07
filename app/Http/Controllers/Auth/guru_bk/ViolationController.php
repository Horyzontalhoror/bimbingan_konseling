<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use App\Models\Student;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Violation::with('student')->latest()->paginate(10);
        return view('guru_bk.violations.index', compact('violations'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();
        return view('guru_bk.violations.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'action' => 'nullable|string',
        ]);

        Violation::create($request->only([
            'student_id', 'date', 'type', 'description', 'action'
        ]));

        return redirect()->route('schedules.index')
            ->with('success', 'Pelanggaran berhasil ditambahkan.');
    }

    public function edit(Violation $violation)
    {
        $students = Student::orderBy('name')->get();
        return view('guru_bk.violations.edit', compact('violation', 'students'));
    }

    public function update(Request $request, Violation $violation)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'action' => 'nullable|string',
        ]);

        $violation->update($request->only([
            'student_id', 'date', 'type', 'description', 'action'
        ]));

        return redirect()->route('schedules.index')
            ->with('success', 'Pelanggaran berhasil diperbarui.');
    }

    public function destroy(Violation $violation)
    {
        $violation->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Pelanggaran berhasil dihapus.');
    }
}
