@extends('layouts.student')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h1 class="h4">Selamat Datang, {{ Auth::guard('student')->user()->student->name ?? 'Siswa' }}</h1>
        <p class="text-muted">Berikut adalah ringkasan status akademik dan konseling kamu.</p>
    </div>
</div>

<div class="row">
    <!-- Kategori -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-uppercase mb-1">Kategori</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ Auth::guard('student')->user()->student->nilai->kategori ?? 'Belum tersedia' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Rata-rata -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-uppercase mb-1">Rata-Rata Nilai</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ Auth::guard('student')->user()->student->nilai->rata_rata ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Kelas -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-uppercase mb-1">Kelas</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                    {{ Auth::guard('student')->user()->student->class ?? '-' }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jadwal Konseling (opsional, jika ada data) -->

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header font-weight-bold">Jadwal Konseling</div>
            <div class="card-body">
                <p>Belum ada jadwal konseling yang terdaftar.</p>
            </div>
        </div>
    </div>
</div>

@endsection
