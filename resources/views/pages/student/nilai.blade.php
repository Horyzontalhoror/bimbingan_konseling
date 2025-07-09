@extends('layouts.student')

@section('title', 'Data Nilai')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Halaman --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-chart-bar me-2 text-primary"></i> Data Nilai
            </h1>
            {{-- Tombol Kembali (Opsional, tergantung navigasi aplikasi) --}}
            {{-- <a href="{{ route('students.index') }}" class="btn btn-secondary btn-icon-split shadow-sm">
            <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
            <span class="text">Kembali ke Daftar Siswa</span>
        </a> --}}
        </div>

        {{-- Informasi Siswa Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-graduate me-2"></i> Informasi Siswa
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
                <p class="text-muted mt-3 mb-0"><i class="fas fa-info-circle me-1"></i> Berikut adalah hasil nilai akademik
                    kamu.</p>
            </div>
        </div>

        {{-- Data Nilai Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-book-open me-2"></i> Rincian Nilai Mata Pelajaran
                </h6>
            </div>
            <div class="card-body">
                @if ($nilai)
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover align-middle" width="100%"
                            cellspacing="0">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col" class="py-3">B. Indonesia</th>
                                    <th scope="col" class="py-3">B. Inggris</th>
                                    <th scope="col" class="py-3">Matematika</th>
                                    <th scope="col" class="py-3">IPA</th>
                                    <th scope="col" class="py-3">IPS</th>
                                    <th scope="col" class="py-3">Agama</th>
                                    <th scope="col" class="py-3">PPKn</th>
                                    <th scope="col" class="py-3">SosBud</th>
                                    <th scope="col" class="py-3">TIK</th>
                                    <th scope="col" class="py-3">Penjas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td><span class="badge badge-primary px-3 py-2">{{ $nilai->bindo }}</span></td>
                                    <td><span class="badge badge-primary px-3 py-2">{{ $nilai->bing }}</span></td>
                                    <td><span class="badge badge-primary px-3 py-2">{{ $nilai->mat }}</span></td>
                                    <td><span class="badge badge-primary px-3 py-2">{{ $nilai->ipa }}</span></td>
                                    <td><span class="badge badge-primary px-3 py-2">{{ $nilai->ips }}</span></td>
                                    <td><span class="badge badge-primary px-3 py-2">{{ $nilai->agama }}</span></td>
                                    <td><span class="badge badge-primary px-3 py-2">{{ $nilai->ppkn }}</span></td>
                                    <td><span class="badge badge-primary px-3 py-2">{{ $nilai->sosbud }}</span></td>
                                    <td><span class="badge badge-primary px-3 py-2">{{ $nilai->tik }}</span></td>
                                    <td><span class="badge badge-primary px-3 py-2">{{ $nilai->penjas }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Belum ada data nilai yang
                            tersedia untuk siswa ini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
