@extends('layouts.student')

@section('title', 'Dasbor Siswa')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Halaman --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt me-2 text-primary"></i> Selamat Datang, {{ $student->name }}!
        </h1>
        {{-- Tombol atau navigasi tambahan bisa ditambahkan di sini --}}
    </div>

    {{-- Informasi Siswa Card --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user-graduate me-2"></i> Informasi Profil
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>Nama:</strong> <span class="text-gray-900">{{ $student->name }}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>NISN:</strong> <span class="text-gray-900">{{ $student->nisn }}</span>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Kelas:</strong> <span class="text-gray-900">{{ $student->class }}</span>
                </div>
            </div>
            <p class="text-muted mt-3 mb-0">
                <i class="fas fa-info-circle me-1"></i> Informasi dasar profil siswa.
            </p>
        </div>
    </div>

    {{-- Hasil Prediksi K-NN Card --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-chart-line me-2"></i> Hasil Prediksi K-NN
            </h6>
        </div>
        <div class="card-body">
            <p class="text-muted mb-3">
                <i class="fas fa-lightbulb me-1"></i> Berikut adalah prediksi kategori kamu berdasarkan analisis data.
            </p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Nilai Akademik:
                    <span class="badge badge-pill px-3 py-2
                        @if (($prediksi['KNN-Nilai']->kategori ?? '-') === 'Baik') badge-success
                        @elseif (($prediksi['KNN-Nilai']->kategori ?? '-') === 'Cukup') badge-warning
                        @elseif (($prediksi['KNN-Nilai']->kategori ?? '-') === 'Butuh Bimbingan') badge-danger
                        @else badge-secondary @endif">
                        {{ $prediksi['KNN-Nilai']->kategori ?? '-' }}
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Kehadiran (Absensi):
                    <span class="badge badge-pill px-3 py-2
                        @if (($prediksi['KNN-Absen']->kategori ?? '-') === 'Rajin') badge-success
                        @elseif (($prediksi['KNN-Absen']->kategori ?? '-') === 'Cukup') badge-warning
                        @elseif (($prediksi['KNN-Absen']->kategori ?? '-') === 'Sering Absen') badge-danger
                        @else badge-secondary @endif">
                        {{ $prediksi['KNN-Absen']->kategori ?? '-' }}
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Tingkat Pelanggaran:
                    <span class="badge badge-pill px-3 py-2
                        @if (($prediksi['KNN-Pelanggaran']->kategori ?? '-') === 'Tidak Pernah') badge-success
                        @elseif (($prediksi['KNN-Pelanggaran']->kategori ?? '-') === 'Ringan') badge-warning
                        @elseif (($prediksi['KNN-Pelanggaran']->kategori ?? '-') === 'Sering') badge-danger
                        @else badge-secondary @endif">
                        {{ $prediksi['KNN-Pelanggaran']->kategori ?? '-' }}
                    </span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center bg-light font-weight-bold">
                    Keputusan Akhir:
                    <span class="badge badge-pill px-3 py-2
                        @if (($prediksi['Final']->kategori ?? '-') === 'Baik') badge-success
                        @elseif (($prediksi['Final']->kategori ?? '-') === 'Cukup') badge-warning
                        @elseif (($prediksi['Final']->kategori ?? '-') === 'Butuh Bimbingan') badge-danger
                        @else badge-secondary @endif">
                        <i class="fas
                            @if (($prediksi['Final']->kategori ?? '-') === 'Baik') fa-check-circle
                            @elseif (($prediksi['Final']->kategori ?? '-') === 'Cukup') fa-exclamation-circle
                            @elseif (($prediksi['Final']->kategori ?? '-') === 'Butuh Bimbingan') fa-times-circle
                            @else fa-info-circle @endif me-1"></i>
                        {{ $prediksi['Final']->kategori ?? '-' }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
