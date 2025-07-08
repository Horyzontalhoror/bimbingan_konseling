@extends('layouts.app')

@section('title', 'Tambah Jadwal Konseling')

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
                <i class="fas fa-calendar-plus mr-2"></i> Buat Jadwal Konseling Baru
            </h1>
            <a href="{{ route('schedules.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali ke Daftar Jadwal
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Formulir Penjadwalan</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('schedules.store') }}" method="POST">
                            @csrf

                            <!-- Nama Siswa -->
                            <div class="form-group">
                                <label for="nisn" class="font-weight-bold">Nama Siswa</label>
                                <select name="nisn" id="nisn"
                                    class="form-control select2 @error('nisn') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih atau cari siswa...</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->nisn }}" data-nisn="{{ $student->nisn }}"
                                            data-class="{{ $student->class }}"
                                            {{ old('nisn') == $student->nisn ? 'selected' : '' }}>
                                            {{ $student->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nisn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info Tambahan Siswa (dinamis) -->
                            <div id="info-siswa" class="mb-3 p-3 bg-gray-100 rounded" style="display: none;">
                                <p class="mb-1"><strong>NISN:</strong> <span id="display-nisn"
                                        class="font-weight-bold text-primary"></span></p>
                                <p class="mb-0"><strong>Kelas:</strong> <span id="display-class"
                                        class="font-weight-bold text-primary"></span></p>
                            </div>

                            <!-- Tanggal & Jam -->
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="date" class="font-weight-bold">Tanggal</label>
                                    <input type="date" id="date" name="date"
                                        class="form-control @error('date') is-invalid @enderror"
                                        value="{{ old('date', date('Y-m-d')) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="time" class="font-weight-bold">Jam</label>
                                    <input type="time" id="time" name="time"
                                        class="form-control @error('time') is-invalid @enderror"
                                        value="{{ old('time') }}" required>
                                    @error('time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="form-group">
                                <label for="note" class="font-weight-bold">Catatan / Topik Konseling</label>
                                <textarea id="note" name="note" rows="4" class="form-control @error('note') is-invalid @enderror"
                                    placeholder="Tuliskan topik atau catatan awal untuk sesi konseling ini...">{{ old('note') }}</textarea>
                                @error('note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group">
                                <label for="status" class="font-weight-bold">Status</label>
                                <select id="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="Dijadwalkan" {{ old('status') == 'Dijadwalkan' ? 'selected' : '' }}>
                                        Dijadwalkan</option>
                                    <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="Batal" {{ old('status') == 'Batal' ? 'selected' : '' }}>Batal</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="border-top mt-4 pt-3 d-flex justify-content-end">
                                <a href="{{ route('schedules.index') }}" class="btn btn-secondary mr-2">Batal</a>
                                <button type="submit" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                                    <span class="text">Simpan Jadwal</span>
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
                const selected = $('#nisn').find('option:selected');
                const nisn = selected.data('nisn');
                const kelas = selected.data('class');

                if (nisn && kelas) {
                    $('#display-nisn').text(nisn);
                    $('#display-class').text(kelas);
                    $('#info-siswa').slideDown();
                } else {
                    $('#info-siswa').slideUp();
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
