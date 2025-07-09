@extends('layouts.student')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="row justify-content-center"> {{-- Menggunakan grid Bootstrap untuk layout --}}
        <div class="col-lg-10 col-xl-8 dashboard-container"> {{-- Menyesuaikan lebar konten --}}

            {{-- Header Halaman --}}
            <div class="header-section animate-fade-in-down">
                <h1 class="header-title">
                    <i class="fas fa-tachometer-alt header-icon animate-bounce-icon"></i>
                    Selamat Datang, <span
                        class="user-name">{{ Auth::guard('student')->user()->student->name ?? 'Siswa' }}</span>
                </h1>
            </div>

            {{-- Welcome Card for Students --}}
            <div class="welcome-card-student animate-fade-in">
                {{-- Decorative shapes --}}
                <div class="decorative-shape-1"></div>
                <div class="decorative-shape-2"></div>

                <div class="position-relative z-1"> {{-- Konten di atas shape dekoratif --}}
                    <p class="student-welcome-text">
                        <span style="font-size: 1.5rem; margin-right: 0.5rem;">🌟</span> "Langkah Awal Menuju Masa Depan
                        Cerah Dimulai di Sini!"
                    </p>
                    <p class="student-welcome-text">
                        <span style="font-size: 1.5rem; margin-right: 0.5rem;">💡</span> "Dapatkan informasi akademik,
                        kegiatan sekolah, jadwal penting, dan lainnya secara lengkap dan terpercaya."
                    </p>
                    <blockquote class="student-quote-block">
                        <p>
                            "Pendidikan adalah senjata paling ampuh yang bisa kamu gunakan untuk mengubah dunia."
                            <br>– Nelson Mandela
                        </p>
                    </blockquote>
                </div>
            </div>

            {{-- Anda bisa menambahkan bagian lain di sini jika diperlukan,
                 misalnya daftar pengumuman, jadwal, nilai, dll.,
                 dengan gaya card SB Admin 2. --}}

        </div>
    </div>
@endsection
