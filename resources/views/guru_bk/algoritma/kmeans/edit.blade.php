@extends('layouts.app')
@section('title', 'Edit Konfigurasi KMeans')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <strong>Edit Konfigurasi Centroid</strong>
                </div>

                <div class="card-body">
                    <form action="{{ route('algoritma.kmeans.update', $konfigurasi->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama_centroid">Nama Centroid</label>
                            <input type="text" name="nama_centroid" id="nama_centroid" class="form-control" value="{{ old('nama_centroid', $konfigurasi->nama_centroid) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nilai_centroid">Nilai Rata-rata Centroid</label>
                            <input type="number" step="0.01" name="nilai_centroid" id="nilai_centroid" class="form-control" value="{{ old('nilai_centroid', $konfigurasi->nilai_centroid) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control" required>
                                <option value="Baik" {{ $konfigurasi->kategori == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Cukup" {{ $konfigurasi->kategori == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                <option value="Butuh Bimbingan" {{ $konfigurasi->kategori == 'Butuh Bimbingan' ? 'selected' : '' }}>Butuh Bimbingan</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        <a href="{{ route('algoritma.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
