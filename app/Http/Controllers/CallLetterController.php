<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class CallLetterController extends Controller
{
    public function form()
    {
        $students = Student::all();
        return view('call-letter.form', compact('students'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'reason' => 'required|string|max:255',
        ]);

        $student = Student::find($request->student_id);
        $reason = $request->reason;

        return view('call-letter.result', compact('student', 'reason'));
    }
}
