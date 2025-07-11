@extends('layouts.app')

@section('title', 'Buat Surat Panggilan')

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
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-envelope-open-text mr-2"></i> Buat Surat Panggilan Orang Tua
            </h1>
            <a href="{{ route('call-letter.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali ke Riwayat
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Formulir Pembuatan Surat</h6>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="tanggal" value="{{ now()->toDateString() }}">
                        <form action="{{ route('call-letter.generate') }}" method="POST">
                            @csrf

                            <!-- Nama Siswa -->
                            <div class="form-group">
                                <label for="student_id" class="font-weight-bold">Nama Siswa</label>
                                <select name="student_id" id="student_id"
                                    class="form-control select2 @error('student_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih atau cari siswa...</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" data-nisn="{{ $student->nisn }}"
                                            data-class="{{ $student->class }}"
                                            data-wali="{{ $student->wali_kelas ?? 'Belum diatur' }}"
                                            {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info Tambahan Siswa (dinamis) -->
                            <div id="info-siswa" class="mb-3 p-3 bg-gray-100 rounded" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>NISN:</strong> <span id="display-nisn"
                                                class="font-weight-bold text-primary"></span></p>
                                        <p class="mb-0"><strong>Kelas:</strong> <span id="display-class"
                                                class="font-weight-bold text-primary"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-0"><strong>Wali Kelas:</strong> <span id="display-wali"
                                                class="font-weight-bold text-primary"></span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Wali Kelas -->
                            <div class="form-group">
                                <label for="wali_kelas" class="font-weight-bold">Nama Wali Kelas</label>
                                <input type="text" id="wali_kelas" name="wali_kelas"
                                    class="form-control @error('wali_kelas') is-invalid @enderror"
                                    value="{{ old('wali_kelas') }}" required placeholder="Masukkan nama wali kelas...">
                                @error('wali_kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jadwal Pertemuan -->
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="tanggal_pertemuan" class="font-weight-bold">Tanggal Pertemuan</label>
                                    <input type="date" id="tanggal_pertemuan" name="tanggal_pertemuan"
                                        class="form-control @error('tanggal_pertemuan') is-invalid @enderror"
                                        value="{{ old('tanggal_pertemuan', date('Y-m-d')) }}" required>
                                    @error('tanggal_pertemuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="waktu_pertemuan" class="font-weight-bold">Waktu</label>
                                    <input type="time" id="waktu_pertemuan" name="waktu_pertemuan"
                                        class="form-control @error('waktu_pertemuan') is-invalid @enderror"
                                        value="{{ old('waktu_pertemuan') }}" required>
                                    @error('waktu_pertemuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tempat_pertemuan" class="font-weight-bold">Tempat</label>
                                    <input type="text" id="tempat_pertemuan" name="tempat_pertemuan"
                                        class="form-control @error('tempat_pertemuan') is-invalid @enderror"
                                        value="{{ old('tempat_pertemuan', 'Ruang BK') }}" required>
                                    @error('tempat_pertemuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Alasan Pemanggilan -->
                            <div class="form-group">
                                <label for="reason" class="font-weight-bold">Keperluan / Alasan Pemanggilan</label>
                                <textarea id="reason" name="reason" class="form-control @error('reason') is-invalid @enderror" rows="4"
                                    required placeholder="Jelaskan secara singkat alasan pemanggilan orang tua/wali murid...">{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Aksi -->
                            <input type="hidden" name="tanggal" value="{{ now()->toDateString() }}">
                            <div class="border-top mt-4 pt-3 d-flex justify-content-end">
                                <a href="{{ route('call-letter.index') }}" class="btn btn-secondary mr-2">Batal</a>
                                <button type="submit" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50"><i class="fas fa-print"></i></span>
                                    <span class="text">Buat & Tampilkan Surat</span>
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
            $('.select2').select2({
                placeholder: "Pilih atau cari siswa...",
                width: '100%'
            });

            // Fungsi untuk memperbarui tampilan info siswa
            function updateStudentInfo() {
                const selected = $('#student_id').find('option:selected');
                const nisn = selected.data('nisn');
                const kelas = selected.data('class');
                const wali = selected.data('wali');

                if (nisn && kelas) {
                    $('#display-nisn').text(nisn);
                    $('#display-class').text(kelas);
                    $('#display-wali').text(wali);
                    $('#wali_kelas').val(wali); // Otomatis isi field wali kelas
                    $('#info-siswa').slideDown();
                } else {
                    $('#info-siswa').slideUp();
                }
            }

            // Panggil fungsi saat pilihan Select2 berubah
            $('#student_id').on('change', function() {
                updateStudentInfo();
            });

            // Panggil fungsi saat halaman dimuat (untuk menangani old value dari validasi)
            if ($('#student_id').val()) {
                updateStudentInfo();
            }
        });
    </script>
@endpush
