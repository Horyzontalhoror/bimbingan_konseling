@extends('layouts.app')

@section('title', 'Rekomendasi Siswa')

@push('styles')
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
        {{-- Header --}}
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-layer-group text-primary mr-2"></i>Rekomendasi Siswa
            </h1>
            <a href="{{ route('algoritma.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Kembali
            </a>
        </div>

        {{-- Statistik Final --}}
        <div class="row">
            @php
                $finalCount = collect($kmeans)->groupBy('final');
            @endphp

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Kategori Baik</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $finalCount['Baik']->count() ?? 0 }} Siswa
                                </div>
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
                                    {{ $finalCount['Cukup']->count() ?? 0 }} Siswa
                                </div>
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
                                    {{ $finalCount['Butuh Bimbingan']->count() ?? 0 }} Siswa
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel KMeans --}}
        <div class="card shadow mb-5">
            <div class="card-header py-3 bg-primary">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-project-diagram mr-2"></i>Hasil Clustering
                    K-Means</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tableKmeans" class="table table-bordered table-hover">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>Nama</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                                <th>Nilai</th>
                                <th>Absensi</th>
                                <th>Pelanggaran</th>
                                <th>Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kmeans as $row)
                                <tr class="text-center">
                                    <td class="text-left font-weight-bold">{{ $row->name }}</td>
                                    <td>{{ $row->nisn }}</td>
                                    <td>{{ $row->class }}</td>
                                    <td>{!! badgeKategori($row->nilai_kmeans) !!}</td>
                                    <td>{!! badgeKategori($row->absen_kmeans) !!}</td>
                                    <td>{!! badgeKategori($row->pelanggaran_kmeans) !!}</td>
                                    <td>{!! badgeKategori($row->final) !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tabel KNN --}}
        <div class="card shadow">
            <div class="card-header py-3 bg-info">
                <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-brain mr-2"></i>Hasil Klasifikasi KNN</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tableKnn" class="table table-bordered table-hover">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>Nama</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                                <th>Nilai (KNN)</th>
                                <th>Absensi (KNN)</th>
                                <th>Pelanggaran (KNN)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($knn as $row)
                                <tr class="text-center">
                                    <td class="text-left font-weight-bold">{{ $row->name }}</td>
                                    <td>{{ $row->nisn }}</td>
                                    <td>{{ $row->class }}</td>
                                    <td>{!! badgeKategori($row->nilai_knn) !!}</td>
                                    <td>{!! badgeKategori($row->absen_knn) !!}</td>
                                    <td>{!! badgeKategori($row->pelanggaran_knn) !!}</td>
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
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(function() {
            $('#tableKmeans').DataTable({
                responsive: true,
                order: [
                    [0, 'asc']
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ siswa",
                    zeroRecords: "Tidak ditemukan data",
                    infoEmpty: "Data kosong",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                }
            });

            $('#tableKnn').DataTable({
                responsive: true,
                order: [
                    [0, 'asc']
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ siswa",
                    zeroRecords: "Tidak ditemukan data",
                    infoEmpty: "Data kosong",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    },
                }
            });
        });
    </script>
@endpush
