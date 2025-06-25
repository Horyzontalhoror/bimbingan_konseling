<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('student.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Siswa BK</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('student.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Jadwal Konseling -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-calendar-alt"></i>
            <span>Jadwal Konseling</span>
        </a>
    </li>

    <!-- Lihat Nilai -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-chart-line"></i>
            <span>Nilai Akademik</span>
        </a>
    </li>

    <!-- Surat Panggilan -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-envelope-open-text"></i>
            <span>Surat Panggilan</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
</ul>
