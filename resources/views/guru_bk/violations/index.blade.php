@extends('layouts.app')

@section('title', 'Data Pelanggaran Siswa')

@push('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <style>
        .table th,
        .table td {
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-gavel mr-2"></i>Manajemen Pelanggaran Siswa</h1>
            <a href="{{ route('violations.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Catat Pelanggaran Baru</span>
            </a>
        </div>

        <!-- Kartu Statistik -->
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Pelanggaran
                                    Tercatat</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $violations->count() }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-list-ol fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Siswa Pernah
                                    Melanggar</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $violations->unique('nisn')->count() }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-users-cog fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Poin Tertinggi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @if ($poinTertinggi)
                                        {{ $poinTertinggi->total_poin }} ({{ $poinTertinggi->name }})
                                    @else
                                        0
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto"><i class="fas fa-trophy fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-2"></i>Daftar Riwayat Pelanggaran
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover" width="100%">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>No</th>
                                <th class="text-left">Nama Siswa</th>
                                <th>Tanggal</th>
                                <th class="text-left">Jenis Pelanggaran</th>
                                <th>Poin</th>
                                <th>Status Tindakan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($violations as $index => $v)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-left">
                                        <div class="font-weight-bold text-dark">{{ $v->student->name ?? 'Siswa Dihapus' }}
                                        </div>
                                        <small class="text-muted">{{ $v->student->nisn ?? '-' }} |
                                            {{ $v->student->class ?? '-' }}</small>
                                    </td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($v->date)->isoFormat('D MMM Y') }}
                                    </td>
                                    <td class="text-left" data-toggle="tooltip" data-placement="top"
                                        title="{{ $v->description ?? 'Tidak ada deskripsi.' }}" style="cursor: help;">
                                        {{ $v->jenis->nama ?? 'N/A' }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-danger p-2">{{ $v->jenis->poin ?? 0 }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($v->action)
                                            <span class="badge badge-success p-2"><i class="fas fa-check mr-1"></i>
                                                Ditindaklanjuti</span>
                                        @else
                                            <span class="badge badge-secondary p-2"><i
                                                    class="fas fa-hourglass-half mr-1"></i> Belum Diproses</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('violations.edit', $v->id) }}"
                                            class="btn btn-warning btn-circle btn-sm" title="Edit & Tindak Lanjut">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('violations.destroy', $v->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data pelanggaran ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-circle btn-sm" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            var table = $('#dataTable').DataTable({
                responsive: true,
                language: {
                    search: "Cari Siswa:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                    zeroRecords: "Tidak ditemukan data yang cocok",
                    infoEmpty: "Tidak ada data pelanggaran",
                    infoFiltered: "(difilter dari _MAX_ total data)"
                },
                order: [
                    [2, "desc"]
                ] // Default sorting berdasarkan tanggal terbaru
            });

            // Inisialisasi Tooltip setelah DataTable selesai digambar
            table.on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            // Inisialisasi awal untuk halaman pertama
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
