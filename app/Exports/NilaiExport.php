<?php

namespace App\Exports;

use App\Models\Nilai;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class NilaiExport implements FromCollection
{
    public function collection()
    {
        return Nilai::when(Request::get('kategori'), fn($q) => $q->where('kategori', Request::get('kategori')))
            ->when(Request::get('kelas'), fn($q) => $q->where('class', Request::get('kelas')))
            ->when(Request::get('q'), function ($q) {
                $search = Request::get('q');
                $q->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('nisn', 'like', "%{$search}%");
                });
            })
            ->get();
    }
}
