@extends('layouts.app')

@section('title', 'Data Siswa')

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
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            color: #6e707e;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + .75rem);
        }
    </style>
@endpush


@section('content')
    <div class="container-fluid">

        <!-- Judul Halaman -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-users mr-2"></i>Data Siswa</h1>
            <a href="{{ route('students.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah Siswa Baru</span>
            </a>
        </div>

        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Card Utama untuk Tabel dan Filter -->
        <div class="card shadow mb-4">
            <!-- Card Header - dengan Dropdown untuk Filter -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-2"></i>Tabel Data Siswa</h6>
                <a href="#collapseFilter" class="btn btn-sm btn-info" data-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="collapseFilter">
                    <i class="fas fa-filter mr-1"></i> Filter
                </a>
            </div>

            <!-- Area Filter yang bisa disembunyikan -->
            <div class="collapse" id="collapseFilter">
                <div class="card-body bg-light">
                    <form method="GET" action="{{ route('students.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-5">
                                <label for="q" class="form-label">Cari Nama atau NISN:</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" name="q" id="q" class="form-control"
                                        placeholder="Ketik nama atau NISN siswa..." value="{{ request('q') }}">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label for="kelas" class="form-label">Filter Berdasarkan Kelas:</label>
                                <select name="kelas" id="kelas" class="form-control select2-class">
                                    <option value="">Tampilkan Semua Kelas</option>
                                    @foreach ($semuaKelas as $kelas)
                                        <option value="{{ $kelas }}"
                                            {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 d-flex mt-3 mt-md-0">
                                <button type="submit" class="btn btn-primary w-100 mr-2"><i class="fas fa-check mr-1"></i>
                                    Terapkan
                                </button>
                                <a href="{{ route('students.index') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-sync-alt">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card Body - Tabel Utama -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Siswa</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                                <tr>
                                    <td class="text-center">{{ $students->firstItem() + $index }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->nisn }}</td>
                                    <td><span class="badge badge-info">{{ $student->class }}</span></td>
                                    <td class="text-center">
                                        <a href="{{ route('students.edit', $student) }}"
                                            class="btn btn-warning btn-circle btn-sm" data-toggle="tooltip"
                                            title="Edit Data">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-circle btn-sm"
                                                data-toggle="tooltip" title="Hapus Data">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-exclamation-triangle fa-2x mb-2 text-warning"></i>
                                        <p class="mb-0">Data siswa tidak ditemukan.</p>
                                        <small class="text-muted">Coba ubah kata kunci pencarian atau filter Anda.</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination dan Info Data -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="text-muted mb-0">
                        Menampilkan <b>{{ $students->firstItem() }}</b> - <b>{{ $students->lastItem() }}</b> dari total
                        <b>{{ $students->total() }}</b> siswa.
                    </p>
                    <div class="d-flex">
                        {{ $students->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Inisialisasi Select2 dan Tooltip --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk filter kelas
            $('.select2-class').select2({
                placeholder: "Pilih Kelas",
                width: '100%'
            });

            // Inisialisasi Bootstrap Tooltip untuk tombol aksi
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
