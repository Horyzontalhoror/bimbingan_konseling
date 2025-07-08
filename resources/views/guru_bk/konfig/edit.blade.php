@extends('layouts.app')

@section('title', 'Edit Konfigurasi')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Edit Konfigurasi Centroid</h1>

        <form action="{{ route('konfigurasi.update', $data['nilai']->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card shadow">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Centroid</label>
                        <input type="text" class="form-control" value="{{ $data['nilai']->nama_centroid }}" disabled>
                    </div>

                    {{-- Nilai --}}
                    <div class="form-group">
                        <label>Nilai Centroid *</label>
                        <input type="number" name="nilai_centroid" class="form-control" step="0.01"
                            value="{{ old('nilai_centroid', $data['nilai']->centroid) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori Nilai</label>
                        <input type="text" class="form-control" value="{{ $data['nilai']->kategori }}" disabled>
                    </div>

                    {{-- Absen --}}
                    <div class="form-group">
                        <label>Absen Centroid *</label>
                        <input type="number" name="absen_centroid" class="form-control" step="0.01"
                            value="{{ old('absen_centroid', $data['absen']->centroid) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori Absen</label>
                        <input type="text" class="form-control" value="{{ $data['absen']->kategori }}" disabled>
                    </div>

                    {{-- Pelanggaran --}}
                    <div class="form-group">
                        <label>Pelanggaran Centroid *</label>
                        <input type="number" name="pelanggaran_centroid" class="form-control" step="0.01"
                            value="{{ old('pelanggaran_centroid', $data['pelanggaran']->centroid) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori Pelanggaran</label>
                        <input type="text" class="form-control" value="{{ $data['pelanggaran']->kategori }}" disabled>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                    <a href="{{ route('konfigurasi.index') }}" class="btn btn-secondary mt-3">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
