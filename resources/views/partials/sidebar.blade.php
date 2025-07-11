<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center py-3" href="{{ route('dashboard') }}">
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

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Manajemen
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#algoritmaDropdown"
            aria-expanded="false" aria-controls="algoritmaDropdown">
            <i class="fas fa-tools"></i>
            <span>Algoritma</span>
        </a>
        <div id="algoritmaDropdown" class="collapse" aria-labelledby="headingAlgoritma" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pengaturan Algoritma:</h6>
                <a class="collapse-item" href="{{ route('algoritma.index') }}">
                    <i class="fas fa-brain fa-fw mr-2"></i>
                    <span>Algoritma</span>
                </a>
                <a class="collapse-item" href="{{ route('rekomendasi.perbandingan') }}">
                    <i class="fas fa-lightbulb fa-fw mr-2"></i>
                    <span>Rekomendasi</span>
                </a>
                <a class="collapse-item" href="{{ route('konfigurasi.index') }}">
                    <i class="fas fa-sliders-h fa-fw mr-2"></i>
                    <span>Konfigurasi</span>
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('students.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Siswa</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('nilai.index') }}">
            <i class="fas fa-table"></i>
            <span>Data Nilai</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('absensi.index') }}">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Absensi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pelanggaranDropdown"
            aria-expanded="false" aria-controls="pelanggaranDropdown">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Pelanggaran</span>
        </a>
        <div id="pelanggaranDropdown" class="collapse" aria-labelledby="headingPelanggaran"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Manajemen Pelanggaran:</h6>
                <a class="collapse-item" href="{{ route('violations.index') }}">
                    <i class="fas fa-fw fa-exclamation-triangle fa-fw mr-2"></i>
                    <span>Pelanggaran</span>
                </a>
                <a class="collapse-item" href="{{ route('jenis-pelanggaran.index') }}">
                    <i class="fas fa-fw fa-list-alt fa-fw mr-2"></i>
                    <span>Jenis Pelanggaran</span>
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('schedules.index') }}">
            <i class="fas fa-fw fa-calendar"></i>
            <span>Jadwal Konseling</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('call-letter.index') }}">
            <i class="fas fa-fw fa-envelope"></i>
            <span>Panggilan</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline pt-3">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
