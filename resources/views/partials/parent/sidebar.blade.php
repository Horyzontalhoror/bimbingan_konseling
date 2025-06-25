<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('parent.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Orang Tua</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('parent.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nilai Anak -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Nilai Anak</span>
        </a>
    </li>

    <!-- Jadwal Konseling -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Jadwal Konseling</span>
        </a>
    </li>

    <!-- Surat Panggilan -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-envelope-open-text"></i>
            <span>Surat Panggilan</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">
</ul>
