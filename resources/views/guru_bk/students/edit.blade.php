@extends('layouts.app')

@section('title', 'Edit Data Siswa')

@push('styles')
    {{-- Tambahkan style khusus jika diperlukan, misalnya untuk Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Menyesuaikan tampilan Select2 agar serasi dengan tema SB Admin 2 */
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            border: 1px solid #d1d3e2;
            border-radius: .35rem;
            width: 100%;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            color: #6e707e;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + .75rem);
        }

        .is-invalid+.select2-container--default .select2-selection--single {
            border-color: #e74a3b !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user-edit mr-2"></i>Edit Data Siswa</h1>
            <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali ke Daftar Siswa
            </a>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Formulir Perubahan Data Siswa</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('students.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nama Lengkap Siswa</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $student->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nisn">Nomor Induk Siswa Nasional (NISN)</label>
                        <input type="text" id="nisn" name="nisn" class="form-control"
                            value="{{ $student->nisn }}" readonly title="NISN tidak dapat diubah">
                        <small class="form-text text-muted">NISN bersifat unik dan tidak dapat diubah untuk menjaga
                            integritas data.</small>
                    </div>

                    <div class="form-group">
                        <label for="class">Kelas</label>
                        <select id="class" name="class"
                            class="form-control select2-class @error('class') is-invalid @enderror" required>
                            <option value="" disabled>Pilih Kelas</option>
                            {{-- Menambahkan lebih banyak kelas untuk realisme --}}
                            <option value="VIII-A" {{ old('class', $student->class) == 'VIII-A' ? 'selected' : '' }}>VIII-A
                            </option>
                            <option value="VIII-B" {{ old('class', $student->class) == 'VIII-B' ? 'selected' : '' }}>VIII-B
                            </option>
                            <option value="VIII-C" {{ old('class', $student->class) == 'VIII-C' ? 'selected' : '' }}>VIII-C
                            </option>
                            <option value="VIII-D" {{ old('class', $student->class) == 'VIII-D' ? 'selected' : '' }}>VIII-D
                            </option>
                        </select>
                        @error('class')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="border-top pt-3 mt-4">
                        <button type="submit" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50"><i class="fas fa-save"></i></span>
                            <span class="text">Perbarui Data</span>
                        </button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Inisialisasi Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk dropdown kelas
            $('.select2-class').select2({
                placeholder: "Pilih Kelas",
                width: '100%'
            });
        });
    </script>
@endpush
