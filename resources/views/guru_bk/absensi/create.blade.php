@extends('layouts.app')

@section('title', 'Tambah Data Absensi')

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

        .is-invalid+.select2-container .select2-selection--single {
            border-color: #e74a3b !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-calendar-plus mr-2"></i> Tambah Data Absensi
            </h1>
            <a href="{{ route('absensi.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali
            </a>
        </div>


        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Formulir Input Kehadiran Siswa</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('absensi.store') }}" method="POST">
                            @csrf

                            {{-- Nama Siswa --}}
                            <div class="form-group">
                                <label for="nisn" class="font-weight-bold">Nama Siswa</label>
                                <select name="nisn" id="nisn"
                                    class="form-control select2 @error('nisn') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih atau cari siswa...</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->nisn }}" data-nisn="{{ $student->nisn }}"
                                            data-class="{{ $student->class }}"
                                            {{ old('nisn') == $student->nisn ? 'selected' : '' }}>
                                            {{ $student->name }} - ({{ $student->class }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('nisn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Info Tambahan Siswa (dinamis) --}}
                            <div id="info-siswa" class="mb-4 p-3 bg-gray-100 rounded" style="display: none;">
                                <p class="mb-1"><strong>NISN:</strong> <span id="display-nisn"
                                        class="font-weight-bold text-primary"></span></p>
                                <p class="mb-0"><strong>Kelas:</strong> <span id="display-class"
                                        class="font-weight-bold text-primary"></span></p>
                            </div>

                            {{-- Tanggal Absensi --}}
                            <div class="form-group">
                                <label for="tanggal" class="font-weight-bold">Tanggal Absensi</label>
                                <input type="date" name="tanggal" id="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">
                            <h6 class="font-weight-bold mb-3">Input Jumlah Kehadiran</h6>

                            <div class="form-row">
                                <div class="form-group col-md-4 col-lg-2">
                                    <label for="hadir" class="text-success">Hadir</label>
                                    <input type="number" name="hadir" id="hadir"
                                        class="form-control @error('hadir') is-invalid @enderror" min="0"
                                        value="{{ old('hadir', 0) }}">
                                    @error('hadir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 col-lg-2">
                                    <label for="sakit" class="text-warning">Sakit</label>
                                    <input type="number" name="sakit" id="sakit"
                                        class="form-control @error('sakit') is-invalid @enderror" min="0"
                                        value="{{ old('sakit', 0) }}">
                                    @error('sakit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4 col-lg-2">
                                    <label for="izin" class="text-info">Izin</label>
                                    <input type="number" name="izin" id="izin"
                                        class="form-control @error('izin') is-invalid @enderror" min="0"
                                        value="{{ old('izin', 0) }}">
                                    @error('izin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-lg-2">
                                    <label for="alpa" class="text-danger">Alpa</label>
                                    <input type="number" name="alpa" id="alpa"
                                        class="form-control @error('alpa') is-invalid @enderror" min="0"
                                        value="{{ old('alpa', 0) }}">
                                    @error('alpa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6 col-lg-2">
                                    <label for="bolos" class="text-dark">Bolos</label>
                                    <input type="number" name="bolos" id="bolos"
                                        class="form-control @error('bolos') is-invalid @enderror" min="0"
                                        value="{{ old('bolos', 0) }}">
                                    @error('bolos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="border-top mt-3 pt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                                    <span class="text">Simpan Data Absensi</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Script untuk Select2 dan info siswa dinamis --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('#nisn').select2({
                placeholder: "Pilih atau cari siswa...",
                allowClear: true,
                width: '100%'
            });

            // Fungsi untuk memperbarui tampilan info siswa
            function updateStudentInfo() {
                const selected = $('#nisn').find('option:selected');
                const nisn = selected.data('nisn');
                const kelas = selected.data('class');

                if (nisn && kelas) {
                    $('#display-nisn').text(nisn);
                    $('#display-class').text(kelas);
                    $('#info-siswa').slideDown(); // Animasi muncul
                } else {
                    $('#info-siswa').slideUp(); // Animasi hilang
                }
            }

            // Panggil fungsi saat pilihan Select2 berubah
            $('#nisn').on('change', function() {
                updateStudentInfo();
            });

            // Panggil fungsi saat halaman dimuat (untuk menangani old value dari validasi)
            if ($('#nisn').val()) {
                updateStudentInfo();
            }
        });
    </script>
@endpush
