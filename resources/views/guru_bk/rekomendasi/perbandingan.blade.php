@extends('layouts.app')

@section('title', 'Rekomendasi Siswa (KMeans)')

@push('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <style>
        .table th,
        .table td {
            vertical-align: middle !important;
        }

        .table thead th {
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        {{-- Header Halaman --}}
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-chart-pie mr-2 text-primary"></i>Rekomendasi Siswa (K-Means)
            </h1>
            <a href="{{ route('algoritma.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali ke Halaman Algoritma
            </a>
        </div>

        <!-- Kartu Statistik Hasil Akhir -->
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kategori Baik</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $siswa->where('final', 'Baik')->count() }} Siswa</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Kategori Cukup</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $siswa->where('final', 'Cukup')->count() }} Siswa</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Butuh Bimbingan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $siswa->where('final', 'Butuh Bimbingan')->count() }} Siswa</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Kartu Tabel --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table mr-2"></i>Detail Hasil Clustering dan Keputusan Akhir
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover" width="100%">
                        <thead class="thead-light">
                            <tr>
                                <th rowspan="2">Nama Siswa</th>
                                <th rowspan="2">NISN</th>
                                <th rowspan="2">Kelas</th>
                                <th colspan="3">Hasil Clustering per Kriteria</th>
                                <th rowspan="2">Keputusan Akhir</th>
                            </tr>
                            <tr>
                                <th>Nilai</th>
                                <th>Absensi</th>
                                <th>Pelanggaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $row)
                                <tr class="text-center">
                                    <td class="text-left font-weight-bold text-dark">{{ $row->name }}</td>
                                    <td>{{ $row->nisn }}</td>
                                    <td>{{ $row->class }}</td>
                                    <td>
                                        @if ($row->nilai === 'Baik')
                                            <span class="badge badge-success">Baik</span>
                                        @elseif ($row->nilai === 'Cukup')
                                            <span class="badge badge-warning">Cukup</span>
                                        @elseif ($row->nilai === 'Butuh Bimbingan')
                                            <span class="badge badge-danger">Butuh Bimbingan</span>
                                        @else
                                            <span class="badge badge-secondary">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->absen === 'Rajin')
                                            <span class="badge badge-success">Rajin</span>
                                        @elseif ($row->absen === 'Cukup')
                                            <span class="badge badge-warning">Cukup</span>
                                        @elseif ($row->absen === 'Sering Absen')
                                            <span class="badge badge-danger">Sering Absen</span>
                                        @else
                                            <span class="badge badge-secondary">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->pelanggaran === 'Tidak Pernah')
                                            <span class="badge badge-success">Tidak Pernah</span>
                                        @elseif ($row->pelanggaran === 'Ringan')
                                            <span class="badge badge-warning">Ringan</span>
                                        @elseif ($row->pelanggaran === 'Sering')
                                            <span class="badge badge-danger">Sering</span>
                                        @else
                                            <span class="badge badge-secondary">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->final === 'Baik')
                                            <span class="badge badge-success p-2"><i class="fas fa-check-circle mr-1"></i>
                                                Baik</span>
                                        @elseif ($row->final === 'Cukup')
                                            <span class="badge badge-warning p-2"><i
                                                    class="fas fa-exclamation-circle mr-1"></i> Cukup</span>
                                        @elseif ($row->final === 'Butuh Bimbingan')
                                            <span class="badge badge-danger p-2"><i class="fas fa-times-circle mr-1"></i>
                                                Butuh Bimbingan</span>
                                        @else
                                            <span class="badge badge-secondary p-2">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="fas fa-info-circle fa-3x text-gray-400 mb-3"></i>
                                        <h5 class="font-weight-bold">Tidak Ada Data Rekomendasi</h5>
                                        <p>Silakan jalankan proses "Keputusan Akhir K-Means" terlebih dahulu.</p>
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
            $('#dataTable').DataTable({
                responsive: true,
                language: {
                    search: "Cari Siswa:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ siswa",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                    zeroRecords: "Tidak ditemukan data yang cocok",
                    infoEmpty: "Tidak ada data yang tersedia",
                    infoFiltered: "(difilter dari _MAX_ total siswa)"
                },
                columnDefs: [{
                        "orderable": false,
                        "targets": [3, 4, 5]
                    }, // Menonaktifkan sorting untuk kolom hasil cluster
                    {
                        "orderable": true,
                        "targets": [0, 1, 2, 6]
                    } // Mengaktifkan sorting untuk kolom lain
                ],
                order: [
                    [0, "asc"]
                ] // Default sorting berdasarkan nama siswa (kolom pertama)
            });
        });
    </script>
@endpush
