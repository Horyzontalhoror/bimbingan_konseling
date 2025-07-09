<?php

namespace App\Http\Controllers\Auth\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CounselingSchedule;
use App\Models\CallLetter;

class StudentDashboardController extends Controller
{
    public function dashboard()
    {
        dd(Auth::guard('student')->user());

        $studentLogin = Auth::guard('student')->user();

        if (!$studentLogin) {
            return redirect()->route('student.login');
        }

        // Relasi ke student dari StudentLogin
        $student = $studentLogin->student;

        if (!$student) {
            return back()->withErrors(['Student data not found.']);
        }

        return view('pages.student.dashboard', compact('student'));
    }

    public function index()
    {

        $studentLogin = Auth::guard('student')->user();
        $student = $studentLogin ? $studentLogin->student : null;

        if (!$student) {
            return redirect()->route('student.index')->withErrors(['Data siswa tidak ditemukan.']);
        }

        $jadwal = CounselingSchedule::where('nisn', $student->nisn)->get();

        return view('pages.student.index', compact('student', 'jadwal'));
    }

    public function konseling()
    {

        $studentLogin = Auth::guard('student')->user();
        $student = $studentLogin ? $studentLogin->student : null;

        if (!$student) {
            return redirect()->route('student.index')->withErrors(['Data siswa tidak ditemukan.']);
        }

        $jadwal = CounselingSchedule::where('nisn', $student->nisn)->get();

        return view('pages.student.konseling', compact('student', 'jadwal'));
    }

    public function nilai()
    {
        $student = Auth::guard('student')->user()->student;

        if (!$student) {
            return redirect()->route('student.login');
        }

        $nilai = $student->nilai; // relasi dari model Student

        return view('pages.student.nilai', compact('student', 'nilai'));
    }

    public function suratPanggilan()
    {
        $studentLogin = Auth::guard('student')->user();
        $student = $studentLogin->student;

        if (!$student) {
            return redirect()->route('student.login');
        }

        $suratList = CallLetter::where('student_id', $student->id)->orderByDesc('tanggal')->get();

        return view('pages.student.surat', compact('student', 'suratList'));
    }
}
