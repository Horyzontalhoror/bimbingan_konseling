<?php

namespace App\Http\Controllers\Auth\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\RekomendasiSiswa;
use App\Models\CallLetter;

class ParentDashboardController extends Controller
{
    public function dashboard()
    {
        $parent = Auth::guard('parent')->user();
        $student = $parent->student;

        if (!$student) {
            return redirect()->back()->withErrors('Data anak tidak ditemukan.');
        }

        $rekomendasi = RekomendasiSiswa::where('nisn', $student->nisn)
            ->orderByDesc('updated_at')
            ->first();

        $nilai = $student->nilai ?? null;
        $jadwal = $student->jadwalKonseling ?? [];

        return view('pages.parent.dashboard', compact(
            'parent',
            'student',
            'rekomendasi',
            'nilai',
            'jadwal'
        ));
    }

    public function index()
    {
        $parent = Auth::guard('parent')->user();
        $student = $parent->student;
        $nilai = $student->nilai ?? null;

        return view('pages.parent.index', compact('student', 'nilai'));
    }

    public function nilai()
    {
        $parent = Auth::guard('parent')->user();
        $student = $parent->student;
        $nilai = $student->nilai ?? null;

        return view('pages.parent.nilai', compact('student', 'nilai'));
    }

    public function jadwalKonseling()
    {
        $parent = Auth::guard('parent')->user();
        $student = $parent->student;
        $jadwal = $student->jadwalKonseling ?? [];

        return view('pages.parent.jadwal_konseling', compact('student', 'jadwal'));
    }

    public function suratPanggilan()
    {
        $parent = Auth::guard('parent')->user();
        $student = $parent->student;

        if (!$student) {
            return redirect()->route('parent.dashboard')->withErrors('Data siswa tidak ditemukan.');
        }

        $surat = CallLetter::where('student_id', $student->id)->orderByDesc('tanggal')->get();

        return view('pages.parent.surat_panggilan', compact('student', 'surat'));
    }
}
