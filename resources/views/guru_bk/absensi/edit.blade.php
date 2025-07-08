@extends('layouts.app')

@section('title', 'Edit Data Absensi')

@push('styles')
    {{-- Style untuk Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            border: 1px solid #d1d3e2;
            border-radius: .35rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            color: #6e707e;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + .75rem);
        }

        .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: #eaecf4;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit mr-2"></i> Edit Data Absensi
            </h1>
            <a href="{{ route('absensi.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Formulir Perubahan Kehadiran</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('absensi.update', $absensi->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Nama Siswa (Disabled) --}}
                            <div class="form-group">
                                <label for="nisn_disabled" class="font-weight-bold">Nama Siswa</label>
                                <input type="text" id="nisn_disabled" class="form-control"
                                    value="{{ $absensi->siswa->name ?? 'Siswa tidak ditemukan' }} (NISN: {{ $absensi->nisn }})"
                                    disabled>
                                <small class="form-text text-muted">Nama siswa tidak dapat diubah pada halaman edit.</small>
                                {{-- Hidden input untuk mengirimkan NISN --}}
                                <input type="hidden" name="nisn" value="{{ $absensi->nisn }}">
                            </div>

                            {{-- Tanggal Absensi --}}
                            <div class="form-group">
                                <label for="tanggal" class="font-weight-bold">Tanggal Absensi</label>
                                <input type="date" name="tanggal" id="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', $absensi->tanggal) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">
                            <h6 class="font-weight-bold mb-3">Perbarui Jumlah Kehadiran</h6>

                            <div class="form-row">
                                <div class="form-group col-md-4 col-lg-2">
                                    <label for="hadir" class="text-success">Hadir</label>
                                    <input type="number" name="hadir" id="hadir"
                                        class="form-control @error('hadir') is-invalid @enderror" min="0"
                                        value="{{ old('hadir', $absensi->hadir) }}">
                                    @error('hadir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 col-lg-2">
                                    <label for="sakit" class="text-warning">Sakit</label>
                                    <input type="number" name="sakit" id="sakit"
                                        class="form-control @error('sakit') is-invalid @enderror" min="0"
                                        value="{{ old('sakit', $absensi->sakit) }}">
                                    @error('sakit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 col-lg-2">
                                    <label for="izin" class="text-info">Izin</label>
                                    <input type="number" name="izin" id="izin"
                                        class="form-control @error('izin') is-invalid @enderror" min="0"
                                        value="{{ old('izin', $absensi->izin) }}">
                                    @error('izin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-lg-2">
                                    <label for="alpa" class="text-danger">Alpa</label>
                                    <input type="number" name="alpa" id="alpa"
                                        class="form-control @error('alpa') is-invalid @enderror" min="0"
                                        value="{{ old('alpa', $absensi->alpa) }}">
                                    @error('alpa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-lg-2">
                                    <label for="bolos" class="text-dark">Bolos</label>
                                    <input type="number" name="bolos" id="bolos"
                                        class="form-control @error('bolos') is-invalid @enderror" min="0"
                                        value="{{ old('bolos', $absensi->bolos) }}">
                                    @error('bolos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="border-top mt-3 pt-3 d-flex justify-content-end">
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
