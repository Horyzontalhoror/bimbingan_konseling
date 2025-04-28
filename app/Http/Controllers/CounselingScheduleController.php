<?php

namespace App\Http\Controllers;

use App\Models\CounselingSchedule;
use App\Models\Student;
use Illuminate\Http\Request;

class CounselingScheduleController extends Controller
{
    public function index()
    {
        $schedules = CounselingSchedule::with('student')->latest()->paginate(10);
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $students = Student::all();
        return view('schedules.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'time' => 'required',
            'note' => 'nullable|string',
            'status' => 'required',
        ]);

        CounselingSchedule::create($request->all());
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(CounselingSchedule $schedule)
    {
        $students = Student::all();
        return view('schedules.edit', compact('schedule', 'students'));
    }

    public function update(Request $request, CounselingSchedule $schedule)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'time' => 'required',
            'note' => 'nullable|string',
            'status' => 'required',
        ]);

        $schedule->update($request->all());
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(CounselingSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
