@extends('layouts.parent')

@section('title', 'Dashboard Orang Tua')

@section('content')

    <div class="container-wrapper">

        {{-- Header Halaman --}}
        <div class="header-section animate-fade-in-down">
            <h1 class="header-title">
                <i class="fas fa-home header-icon animate-bounce-icon"></i> Selamat Datang,
                <span class="user-name">{{ Auth::guard('parent')->user()->name ?? 'Orang Tua' }}</span>!
            </h1>
        </div>

        {{-- Welcome Card with Enhanced Design --}}
        <div class="welcome-card animate-fade-in">
            {{-- Decorative shape --}}
            <div class="decorative-shape-1"></div>
            <div class="decorative-shape-2"></div>

            <div class="welcome-content-wrapper">
                <span class="school-emoji">🏫</span>
                <div>
                    <h2 class="welcome-title">Selamat Datang di Portal Orang Tua!</h2>
                    <p class="welcome-text">
                        Pantau perkembangan buah hati Anda dengan mudah, cepat, dan terpercaya. Akses informasi akademik,
                        kehadiran, nilai, dan catatan penting lainnya hanya dalam satu genggaman.
                    </p>
                </div>
            </div>

            <blockquote class="quote-block">
                <p>
                    "Pendidikan bukan hanya tentang apa yang dipelajari anak, tapi juga tentang bagaimana orang tua terlibat
                    di
                    setiap langkah perjalanannya."
                </p>
            </blockquote>

            <h3 class="features-heading">
                <span class="icon-sparkle">✨</span>Fitur Unggulan untuk Anda:
            </h3>
            <ul class="features-list">
                <li class="features-list-item">
                    <i class="fas fa-chart-line text-green"></i> Laporan nilai & evaluasi siswa
                </li>
                <li class="features-list-item">
                    <i class="fas fa-calendar-check text-blue"></i> Kehadiran harian dan catatan disiplin
                </li>
                <li class="features-list-item">
                    <i class="fas fa-clock text-yellow"></i> Jadwal pelajaran dan agenda sekolah
                </li>
                <li class="features-list-item">
                    <i class="fas fa-bullhorn text-red"></i> Pengumuman penting dari sekolah
                </li>
            </ul>

            <p class="insight-paragraph">
                <span class="icon-bulb">💡</span> Karena setiap langkah kecil anak adalah
                langkah besar bagi masa depannya. Mari kita dampingi bersama, mulai hari ini.
            </p>

            <div class="secure-info-box animate-pulse-once">
                <span class="icon-lock">🔒</span> Aman. Mudah. Real-time.
                <br>Masuk sekarang untuk melihat informasi terbaru tentang anak Anda.
            </div>
        </div>

        {{-- Footer-like section or call to action --}}
        <div class="footer-section animate-fade-in-up">
            <p>Ada pertanyaan atau butuh bantuan? Jangan ragu hubungi <a href="#" class="footer-link">Admin
                    Sekolah</a></p>
        </div>

    </div>
@endsection
