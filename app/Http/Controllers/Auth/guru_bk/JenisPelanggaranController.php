<?php

namespace App\Http\Controllers\Auth\guru_bk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisPelanggaran;

class JenisPelanggaranController extends Controller
{
    public function index()
    {
        $data = JenisPelanggaran::orderBy('poin', 'desc')->get();
        return view('guru_bk.jenis_pelanggaran.index', compact('data'));
    }

    public function create()
    {
        return view('guru_bk.jenis_pelanggaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'poin' => 'required|integer|min:1',
            'keterangan' => 'required|string',
        ]);

        JenisPelanggaran::create($request->all());

        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(JenisPelanggaran $jenis)
    {
        return view('guru_bk.jenis_pelanggaran.edit', compact('jenis'));
    }

    public function update(Request $request, JenisPelanggaran $jenis)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'poin' => 'required|integer|min:1',
            'keterangan' => 'required|string',
        ]);

        $jenis->update($request->all());

        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(JenisPelanggaran $jenis)
    {
        $jenis->delete();
        return redirect()->route('jenis-pelanggaran.index')->with('success', 'Data berhasil dihapus.');
    }
}
