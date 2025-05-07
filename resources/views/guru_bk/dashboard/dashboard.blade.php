@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h1 class="h4">Dashboard Rekomendasi Siswa</h1>
    </div>
</div>

<div class="card p-4">
    <div class="row">

        <!-- KIRI -->
        <div class="col-md-4">
            <div class="card border-left-primary shadow mb-3">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Baik</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">49 Siswa</div>
                </div>
            </div>
            <div class="card border-left-primary shadow mb-3">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Cukup</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">57 Siswa</div>
                </div>
            </div>
            <div class="card border-left-primary shadow">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-uppercase mb-1">Butuh Bimbingan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">1 Siswa</div>
                </div>
            </div>
        </div>

        <!-- TENGAH: Chart -->
        <div class="col-md-4 d-flex align-items-center justify-content-center border shadow" style="height: 290px;">
            <div >
                <canvas id="chartKategori" height="250"></canvas>
            </div>
        </div>

        <!-- KANAN -->
        <div class="col-md-4">
            <div class="alert alert-info">
                <h1 class="h5">Proses Clustering KMeans</h1>
                <p class="text-muted">Mengelompokkan siswa berdasarkan rata-rata nilai mereka.</p>
                <a href="{{ route('cluster') }}" class="btn btn-sm btn-primary mb-3">Proses Clustering KMeans</a>

                <hr>

                <h1 class="h5">Proses Normalisasi</h1>
                <p class="text-muted">Menormalkan nilai siswa ke rentang yang seragam.</p>
                <a href="{{ route('predict') }}" class="btn btn-warning btn-sm mb-3">Jalankan Prediksi K-NN</a>
            </div>
        </div>

    </div>
</div>



<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Tabel Rekomendasi Siswa</strong>
                <div>
                    <a href="{{ route('nilai.export', request()->query()) }}" class="btn btn-success btn-sm mb-3">
                        Export ke Excel
                    </a>
                    <a href="{{ route('nilai.print', request()->query()) }}" class="btn btn-danger btn-sm mb-3">
                        Cetak PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-2 mb-3">
                    <div class="col-md-3">
                        <input type="text" name="q" class="form-control" placeholder="Cari nama atau NISN..." value="{{ request('q') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="kategori" class="form-control">
                            <option value="">Semua Kategori</option>
                            <option value="Baik" {{ request('kategori') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Cukup" {{ request('kategori') == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                            <option value="Butuh Bimbingan" {{ request('kategori') == 'Butuh Bimbingan' ? 'selected' : '' }}>Butuh Bimbingan</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="kelas" class="form-control">
                            <option value="">Semua Kelas</option>
                            @foreach($semuaKelas as $kelas)

                                <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary w-100" type="submit">Terapkan Filter</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>NIS</th>
                                <th>Rata-Rata</th>
                                <th>Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $row)
                                <tr>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->class }}</td>
                                    <td>{{ $row->nisn }}</td>
                                    <td>{{ $row->rata_rata }}</td>
                                    <td>
                                        @if ($row->kategori == 'Butuh Bimbingan')
                                            <span class="badge bg-danger text-white">{{ $row->kategori }}</span>
                                        @elseif ($row->kategori == 'Cukup')
                                            <span class="badge bg-warning text-dark">{{ $row->kategori }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $row->kategori }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $siswa->links('pagination::bootstrap-4') }}
                    <p class="text-muted">
                        Menampilkan {{ $siswa->firstItem() }} - {{ $siswa->lastItem() }} dari total {{ $siswa->total() }} Siswa
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@php
    $labels = $statistik->pluck('kategori');
    $values = $statistik->pluck('total');
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartKategori').getContext('2d');

    new Chart(ctx, {
        type: Math.random() < 0.25 ? 'bar' : (Math.random() < 0.5 ? 'pie' : (Math.random() < 0.75 ? 'doughnut' : 'line')),
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Jumlah Siswa',
                data: {!! json_encode($values) !!},
                backgroundColor: {!! json_encode($labels->map(function($label) {
                    return $label === 'Baik' ? '#2ecc71' : ($label === 'Cukup' ? '#f1c40f' : '#e74c3c');
                })) !!},
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>


@endsection
