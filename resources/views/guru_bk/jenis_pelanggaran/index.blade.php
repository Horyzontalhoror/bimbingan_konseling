@extends('layouts.app')

@section('title', 'Master Jenis Pelanggaran')

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
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-list-ul mr-2"></i> Data Jenis Pelanggaran
            </h1>
            <a href="{{ route('jenis-pelanggaran.create') }}" class="btn btn-primary btn-icon-split shadow-sm">
                <span class="icon text-white-50"><i class="fas fa-plus"></i></span>
                <span class="text">Tambah Jenis Baru</span>
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table mr-2"></i>Daftar Jenis Pelanggaran dan
                    Poin</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover" width="100%">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>No</th>
                                <th class="text-left">Nama Pelanggaran</th>
                                <th>Poin</th>
                                <th class="text-left">Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-left font-weight-bold text-dark">{{ $item->nama }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-danger p-2"
                                            style="font-size: 0.9rem;">{{ $item->poin }}</span>
                                    </td>
                                    <td class="text-left text-muted">
                                        {{ Str::limit($item->keterangan, 90) }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('jenis-pelanggaran.edit', $item->id) }}"
                                            class="btn btn-warning btn-circle btn-sm" data-toggle="tooltip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('jenis-pelanggaran.destroy', $item->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus jenis pelanggaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-circle btn-sm"
                                                data-toggle="tooltip" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="fas fa-info-circle fa-3x text-gray-400 mb-3"></i>
                                        <h5 class="font-weight-bold">Belum Ada Data</h5>
                                        <p>Silakan tambahkan data jenis pelanggaran terlebih dahulu.</p>
                                    </td>
                                </tr>
                            @endforelse
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
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                    zeroRecords: "Tidak ditemukan data yang cocok",
                    infoEmpty: "Tidak ada data yang tersedia",
                    infoFiltered: "(difilter dari _MAX_ total data)"
                },
                columnDefs: [{
                        "orderable": false,
                        "targets": [3, 4]
                    }, // Menonaktifkan sorting untuk Keterangan & Aksi
                ],
                order: [
                    [2, "desc"]
                ] // Default sorting berdasarkan poin tertinggi
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
