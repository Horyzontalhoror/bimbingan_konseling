<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use App\Models\CounselingSchedule;
use App\Models\Student;
use Illuminate\Http\Request;

class CounselingScheduleController extends Controller
{
    public function index()
    {
        $schedules = CounselingSchedule::with('student')
                        ->orderByDesc('date')
                        ->paginate(10);

        return view('guru_bk.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();
        return view('guru_bk.schedules.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'time' => 'required',
            'note' => 'nullable|string',
            'status' => 'required|string',
        ]);

        CounselingSchedule::create($request->only([
            'student_id', 'date', 'time', 'note', 'status'
        ]));

        // return redirect()->route('guru_bk.schedules.index')
        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(CounselingSchedule $schedule)
    {
        $students = Student::orderBy('name')->get();
        return view('guru_bk.schedules.edit', compact('schedule', 'students'));
    }

    public function update(Request $request, CounselingSchedule $schedule)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'time' => 'required',
            'note' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $schedule->update($request->only([
            'student_id', 'date', 'time', 'note', 'status'
        ]));

        // return redirect()->route('guru_bk.schedules.index')
        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(CounselingSchedule $schedule)
    {
        $schedule->delete();

        // return redirect()->route('guru_bk.schedules.index')
        return redirect()->route('schedules.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
