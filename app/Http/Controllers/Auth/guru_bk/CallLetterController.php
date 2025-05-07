<?php

namespace App\Http\Controllers\Auth\guru_bk;
use App\Http\Controllers\Controller;
use App\Models\CallLetter;
use Illuminate\Http\Request;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class CallLetterController extends Controller
{
    public function form()
    {
        $students = Student::all();
        return view('guru_bk.call-letter.form', compact('students'));
    }

    public function index()
    {
        $suratPanggilan = CallLetter::with('student')->latest()->paginate(10);
        return view('guru_bk.call-letter.index', compact('suratPanggilan'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'reason' => 'required|string|max:255',
        ]);

        $student = Student::find($request->student_id);
        $reason = $request->reason;

        return view('guru_bk.call-letter.result', compact('student', 'reason'));
    }

    public function print($student_id)
    {
        $surat = CallLetter::where('student_id', $student_id)->latest()->first();

        if (!$surat) {
            return back()->with('error', 'Surat belum tersedia untuk siswa ini.');
        }

        $student = $surat->student;
        $reason = $surat->keperluan ?? 'Keperluan belum dicatat';

        return Pdf::loadView('guru_bk.call-letter.pdf', compact('student', 'reason'))
                ->stream('surat-panggilan.pdf');
    }

}
