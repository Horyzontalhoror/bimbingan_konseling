<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="sidebar-brand-text mx-3">BK SMP</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('students.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('schedules.index') }}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Jadwal Konseling</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('violations.index') }}">
            <i class="fas fa-fw fa-exclamation-triangle"></i>
            <span>Pelanggaran</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('call-letter.form') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Laporan</span>
        </a>
    </li>

    {{-- <li class="nav-item {{ request()->is('nilai') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('nilai.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Nilai Siswa</span>
        </a>
    </li> --}}

</ul>
