@extends('layouts.app')

@section('title', 'Edit Pelanggaran')

@section('content')
    <div class="container-fluid">
        <div class="mb-4 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-edit me-2"></i> Edit Data Pelanggaran Siswa</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow mb-4"> {{-- Using SB Admin 2's shadow and mb-4 for card --}}
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Form Edit Pelanggaran
                        </h6>
                        <a href="{{ route('violations.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <h4 class="alert-heading small mb-2"><i class="fas fa-exclamation-triangle me-2"></i>
                                    Terjadi Kesalahan!</h4>
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form action="{{ route('violations.update', $violation->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Nama Siswa --}}
                            <div class="form-group mb-4"> {{-- Using form-group for Bootstrap 4 --}}
                                <span class="font-weight-bold text-gray-800">
                                    <i class="fas fa-user-graduate me-2 text-info"></i>
                                    Nama Siswa
                                </span>

                                {{-- Displaying student name as plain text --}}
                                <div class="form-control-plaintext">
                                    {{ $violation->student->name }}
                                </div>

                                {{-- Hidden input to keep siswa for form submission --}}
                                <input type="hidden" name="nisn" value="{{ $violation->nisn }}">

                                @error('nisn')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>



                            {{-- Tanggal Pelanggaran --}}
                            <div class="form-group mb-4">
                                <label for="date" class="font-weight-bold text-gray-800">
                                    <i class="fas fa-calendar-alt me-2 text-warning"></i> Tanggal Pelanggaran
                                </label>
                                <input type="date" name="date" id="date"
                                    class="form-control form-control-user @error('date') is-invalid @enderror"
                                    value="{{ old('date', $violation->date) }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jenis Pelanggaran --}}
                            <div class="form-group mb-4">
                                <label for="jenis_pelanggaran_id" class="font-weight-bold text-gray-800">
                                    <i class="fas fa-exclamation-circle me-2 text-danger"></i> Jenis Pelanggaran
                                </label>
                                <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id"
                                    class="form-control form-control-user @error('jenis_pelanggaran_id') is-invalid @enderror"
                                    required>
                                    {{-- No "Pilih Jenis Pelanggaran" option needed for edit --}}
                                    @foreach ($jenisPelanggaran as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            {{ old('jenis_pelanggaran_id', $violation->jenis_pelanggaran_id) == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama }} ({{ $jenis->poin ?? 0 }} poin)
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_pelanggaran_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Deskripsi Pelanggaran --}}
                            <div class="form-group mb-4">
                                <label for="description" class="font-weight-bold text-gray-800">
                                    <i class="fas fa-align-left me-2 text-secondary"></i> Deskripsi Pelanggaran
                                </label>
                                <textarea name="description" id="description"
                                    class="form-control form-control-user @error('description') is-invalid @enderror" rows="4"
                                    placeholder="Detail singkat tentang pelanggaran...">{{ old('description', $violation->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tindakan --}}
                            <div class="form-group mb-4">
                                <label for="actionInput" class="font-weight-bold text-gray-800">
                                    <i class="fas fa-hand-paper me-2 text-primary"></i> Tindakan
                                </label>
                                <input type="text" name="action" id="actionInput"
                                    class="form-control form-control-user @error('action') is-invalid @enderror"
                                    value="{{ old('action', $violation->action) }}"
                                    placeholder="Masukkan tindakan yang diambil (misal: Peringatan, Skorsing)"
                                    aria-describedby="actionHelp">
                                <small id="actionHelp" class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle me-1"></i> Anda dapat mengubah atau menambahkan tindakan
                                    ini nanti.
                                </small>
                                @error('action')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary btn-icon-split me-2">
                                    <span class="icon text-white-50"><i class="fas fa-sync-alt"></i></span>
                                    {{-- Changed to sync-alt for update --}}
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
