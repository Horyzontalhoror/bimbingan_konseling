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
            'wali_kelas' => 'required|string|max:255',
            'tanggal_pertemuan' => 'required|date',
            'waktu_pertemuan' => 'required',
            'tempat_pertemuan' => 'required|string|max:255',
        ]);

        $student = Student::findOrFail($request->student_id);
        $tanggal_surat = now()->format('Y-m-d');

        return view('guru_bk.call-letter.result', [
            'student' => $student,
            'reason' => $request->reason,
            'wali_kelas' => $request->wali_kelas,
            'tanggal_pertemuan' => $request->tanggal_pertemuan,
            'waktu_pertemuan' => $request->waktu_pertemuan,
            'tempat_pertemuan' => $request->tempat_pertemuan,
            'tanggal_surat' => $tanggal_surat,
        ]);
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

    public function save(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'wali_kelas' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'keperluan' => 'required|string|max:255',
            'waktu_pertemuan' => 'required',
            'tempat_pertemuan' => 'required|string|max:255',
        ]);

        CallLetter::create([
            'student_id' => $request->student_id,
            'wali_kelas' => $request->wali_kelas,
            'tanggal' => $request->tanggal,
            'keperluan' => $request->keperluan,
            'waktu_pertemuan' => $request->waktu_pertemuan,
            'tempat_pertemuan' => $request->tempat_pertemuan,
            'file' => null,
        ]);

        return redirect()->route('call-letter.index')->with('success', 'Surat berhasil disimpan.');
    }

    public function show($id)
    {
        $surat = CallLetter::with('student')->findOrFail($id);
        return view('guru_bk.call-letter.show', compact('surat'));
    }

    public function destroy($id)
    {
        CallLetter::findOrFail($id)->delete();
        return redirect()->route('call-letter.index')->with('success', 'Surat berhasil dihapus.');
    }
}
