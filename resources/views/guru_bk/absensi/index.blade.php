@extends('layouts.app')

@section('title', 'Data Absensi Siswa')

@push('styles')
    {{-- Style untuk Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
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

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">

        <!-- Judul Halaman dan Tombol Aksi -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-calendar-check mr-2"></i>Data Absensi Siswa</h1>
            <a href="{{ route('absensi.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Input Absensi Baru</span>
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

        <!-- Card Utama -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-2"></i>Daftar Kehadiran Siswa</h6>
                <a href="#collapseFilterAbsensi" class="btn btn-sm btn-info" data-toggle="collapse" role="button">
                    <i class="fas fa-filter mr-1"></i> Filter Data
                </a>
            </div>

            <!-- Area Filter -->
            {{-- <div class="collapse @if (request()->any()) show @endif" id="collapseFilterAbsensi"> --}}
            <div class="collapse @if(request()->has('class') || request()->has('bulan')) show @endif" id="collapseFilterAbsensi">
                <div class="card-body bg-light">
                    <form method="GET" action="{{ route('absensi.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-4 mb-2 mb-md-0">
                                <label for="q" class="form-label">Cari Nama / NISN:</label>
                                <input type="text" name="q" id="q" class="form-control"
                                    placeholder="Ketik nama atau NISN..." value="{{ request('q') }}">
                            </div>
                            <div class="col-md-3 mb-2 mb-md-0">
                                <label for="class" class="form-label">Filter Kelas:</label>
                                <select name="class" id="class" class="form-control select2-class">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($classList as $kelas)
                                        <option value="{{ $kelas }}"
                                            {{ request('class') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2 mb-md-0">
                                <label for="bulan" class="form-label">Filter Bulan:</label>
                                <select name="bulan" id="bulan" class="form-control select2-class">
                                    <option value="">Semua Bulan</option>
                                    @foreach ($bulanList as $bulan)
                                        <option value="{{ $bulan }}"
                                            {{ request('bulan') == $bulan ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($bulan . '-01')->isoFormat('MMMM YYYY') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mt-3 mt-md-0">
                                <div class="d-flex">
                                    <button class="btn btn-primary w-100 mr-2" type="submit" title="Terapkan Filter"><i
                                            class="fas fa-check"></i></button>
                                    <a href="{{ route('absensi.index') }}" class="btn btn-secondary w-100"
                                        title="Reset Filter"><i class="fas fa-sync-alt"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Card Body - Tabel -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>No</th>
                                <th class="text-left">Nama Siswa</th>
                                <th>Tanggal</th>
                                <th>Hadir</th>
                                <th>Sakit</th>
                                <th>Izin</th>
                                <th>Alpa</th>
                                <th>Bolos</th>
                                <th>Total Absen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($absensiList as $index => $absensi)
                                <tr>
                                    <td class="text-center">{{ $absensiList->firstItem() + $index }}</td>
                                    <td class="text-left">
                                        <div>{{ $absensi->siswa->name ?? 'Siswa tidak ditemukan' }}</div>
                                        <small class="text-muted">{{ $absensi->nisn }} |
                                            {{ $absensi->siswa->class ?? '' }}</small>
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($absensi->tanggal)->isoFormat('dddd, D MMM YYYY') }}</td>
                                    <td class="text-center"><span
                                            class="badge badge-pill badge-secondary">{{ $absensi->hadir }}</span></td>
                                    <td class="text-center"><span
                                            class="badge badge-pill badge-warning">{{ $absensi->sakit }}</span></td>
                                    <td class="text-center"><span
                                            class="badge badge-pill badge-info">{{ $absensi->izin }}</span></td>
                                    <td class="text-center"><span
                                            class="badge badge-pill badge-danger">{{ $absensi->alpa }}</span></td>
                                    <td class="text-center"><span
                                            class="badge badge-pill badge-dark">{{ $absensi->bolos }}</span></td>
                                    <td class="text-center font-weight-bold">
                                        {{ $absensi->sakit + $absensi->izin + $absensi->alpa + $absensi->bolos }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('absensi.edit', $absensi->id) }}"
                                            class="btn btn-warning btn-circle btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('absensi.destroy', $absensi->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data absensi ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-circle btn-sm"
                                                title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-gray-400 mb-3"></i>
                                        <h5 class="font-weight-bold">Belum Ada Data Absensi</h5>
                                        <p class="text-muted">Tidak ada data yang cocok dengan filter yang diterapkan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <p class="text-muted mb-0 small">
                        Menampilkan <b>{{ $absensiList->firstItem() }}</b>-<b>{{ $absensiList->lastItem() }}</b> dari
                        <b>{{ $absensiList->total() }}</b> data.
                    </p>
                    <div class="d-flex">
                        {{ $absensiList->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Script untuk Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-class').select2({
                width: '100%'
            });
        });
    </script>
@endpush
