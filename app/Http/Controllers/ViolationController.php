<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use App\Models\Student;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Violation::with('student')->latest()->paginate(10);
        return view('violations.index', compact('violations'));
    }

    public function create()
    {
        $students = Student::all();
        return view('violations.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'action' => 'nullable|string',
        ]);

        Violation::create($request->all());
        return redirect()->route('violations.index')->with('success', 'Pelanggaran berhasil ditambahkan.');
    }

    public function edit(Violation $violation)
    {
        $students = Student::all();
        return view('violations.edit', compact('violation', 'students'));
    }

    public function update(Request $request, Violation $violation)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'action' => 'nullable|string',
        ]);

        $violation->update($request->all());
        return redirect()->route('violations.index')->with('success', 'Pelanggaran berhasil diperbarui.');
    }

    public function destroy(Violation $violation)
    {
        $violation->delete();
        return redirect()->route('violations.index')->with('success', 'Pelanggaran berhasil dihapus.');
    }
}
