<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class NilaiExport implements FromCollection
{
    public function collection()
    {
        return DB::table('nilai')
            ->join('students', 'nilai.nisn', '=', 'students.nisn')
            ->select('students.name', 'students.nisn', 'students.class',
                     'nilai.*') // mengambil semua kolom dari nilai
            ->when(Request::get('kategori'), fn($q) => $q->where('nilai.kategori', Request::get('kategori')))
            ->when(Request::get('kelas'), fn($q) => $q->where('students.class', Request::get('kelas')))
            ->when(Request::get('q'), function ($q) {
                $search = Request::get('q');
                $q->where(function ($query) use ($search) {
                    $query->where('students.name', 'like', "%{$search}%")
                          ->orWhere('nilai.nisn', 'like', "%{$search}%");
                });
            })
            ->orderBy('students.class')
            ->orderByDesc('nilai.rata_rata')
            ->get();
    }
}
