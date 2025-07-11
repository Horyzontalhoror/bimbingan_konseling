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

        {{-- Ringkasan Konseling --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-comments me-2"></i> Ringkasan Konseling Terbaru
                </h6>
                <a href="{{ route('student.konseling') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-arrow-right me-1"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if ($jadwalKonseling->isEmpty())
                    <p class="text-muted">Belum ada data konseling.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach ($jadwalKonseling as $item)
                            <li class="list-group-item">
                                <strong>Tanggal:</strong>
                                {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y') }}<br>
                                <strong>Topik:</strong> {{ $item->note ?? 'Tidak tersedia' }}<br>
                                <strong>Status:</strong> <span
                                    class="badge bg-info text-white">{{ $item->status ?? 'Belum Diketahui' }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
