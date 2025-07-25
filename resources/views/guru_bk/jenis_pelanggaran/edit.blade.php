@extends('layouts.app')

@section('title', 'Edit Jenis Pelanggaran')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit mr-2"></i> Edit Jenis Pelanggaran
            </h1>
            <a href="{{ route('jenis-pelanggaran.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali ke Daftar
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Formulir Perubahan Data</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('jenis-pelanggaran.update', $jenis->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama Pelanggaran -->
                            <div class="form-group">
                                <label for="nama" class="font-weight-bold">Nama Pelanggaran</label>
                                <input type="text" id="nama" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $jenis->nama) }}" required
                                    placeholder="Contoh: Terlambat masuk sekolah">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Poin Pelanggaran -->
                            <div class="form-group">
                                <label for="poin" class="font-weight-bold">Poin</label>
                                <input type="number" id="poin" name="poin"
                                    class="form-control @error('poin') is-invalid @enderror"
                                    value="{{ old('poin', $jenis->poin) }}" required min="1" placeholder="Contoh: 5">
                                @error('poin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="form-group">
                                <label for="keterangan" class="font-weight-bold">Keterangan</label>
                                <textarea id="keterangan" name="keterangan" rows="4"
                                    class="form-control @error('keterangan') is-invalid @enderror" required
                                    placeholder="Jelaskan detail mengenai jenis pelanggaran ini...">{{ old('keterangan', $jenis->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="border-top mt-4 pt-3 d-flex justify-content-end">
                                <a href="{{ route('jenis-pelanggaran.index') }}" class="btn btn-secondary mr-2">Batal</a>
                                <button type="submit" class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50"><i class="fas fa-sync-alt"></i></span>
                                    <span class="text">Perbarui Data</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
