@extends('layouts.app')

@section('title', 'Tambah Pelanggaran')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">
        {{-- Page Heading --}}

        <div class="mb-4 text-center">
            <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-plus-circle me-2"></i> Tambah Data Pelanggaran Siswa</h1>
        </div>

        {{-- Main content --}}
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow mb-4"> {{-- Using SB Admin 2's shadow and mb-4 for card --}}
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Form Pelanggaran
                        </h6>
                        <a href="{{ route('violations.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                            {{-- btn-sm for smaller button in header --}}
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('violations.store') }}" method="POST">
                            @csrf

                            {{-- Nama Siswa --}}
                            <div class="form-group mb-3">
                                <label for="student_id" class="font-weight-bold text-gray-800">
                                    <i class="fas fa-user-graduate me-2 text-info"></i> Nama Siswa
                                </label>
                                <select name="student_id" id="student_id"
                                    class="form-control select2 @error('student_id') is-invalid @enderror" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" data-nisn="{{ $student->nisn }}"
                                            data-class="{{ $student->class }}"
                                            {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Info Tambahan Siswa --}}
                            <div id="info-siswa" class="mb-3" style="display: none;">
                                <p class="mb-1"><strong>NISN:</strong> <span id="display-nisn"></span></p>
                                <p class="mb-1"><strong>Kelas:</strong> <span id="display-class"></span></p>
                            </div>


                            {{-- Tanggal Pelanggaran --}}
                            <div class="form-group mb-4">
                                <label for="date" class="font-weight-bold text-gray-800">
                                    <i class="fas fa-calendar-alt me-2 text-warning"></i> Tanggal Pelanggaran
                                </label>
                                <input type="date" name="date" id="date"
                                    class="form-control form-control-user @error('date') is-invalid @enderror"
                                    value="{{ old('date', date('Y-m-d')) }}" required>
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
                                    <option value="">Pilih Jenis Pelanggaran</option>
                                    @foreach ($jenisPelanggaran as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            {{ old('jenis_pelanggaran_id') == $jenis->id ? 'selected' : '' }}>
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
                                    placeholder="Detail singkat tentang pelanggaran...">{{ old('description') }}</textarea>
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
                                    value="{{ old('action') }}"
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
                            <div class="d-flex justify-content-end mt-4"> {{-- Use d-flex and justify-content-end for alignment --}}
                                <button type="submit" class="btn btn-primary btn-icon-split me-2"> {{-- me-2 for margin right --}}
                                    <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                                    <span class="text">Simpan Data</span>
                                </button>
                                {{-- The "Kembali" button is already in the card header, so we can remove it here for cleaner design --}}
                                {{-- If you prefer it here, you can uncomment it and adjust styling --}}
                                {{-- <a href="{{ route('violations.index') }}" class="btn btn-secondary btn-icon-split">
                                <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
                                <span class="text">Kembali</span>
                            </a> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#student_id').select2({
                placeholder: "Pilih atau cari siswa...",
                allowClear: true,
                width: '100%'
            });

            // Tampilkan info NISN dan kelas saat siswa dipilih
            $('#student_id').on('change', function() {
                const selected = $(this).find('option:selected');
                const nisn = selected.data('nisn');
                const kelas = selected.data('class');

                if (nisn && kelas) {
                    $('#display-nisn').text(nisn);
                    $('#display-class').text(kelas);
                    $('#info-siswa').show();
                } else {
                    $('#info-siswa').hide();
                }
            });

            // Jika sudah ada yang terpilih (untuk halaman edit)
            $('#student_id').trigger('change');
        });
    </script>
@endpush
