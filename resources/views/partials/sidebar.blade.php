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
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#algoritmaDropdown"
            aria-expanded="false" aria-controls="algoritmaDropdown">
            <i class="fas fa-tools"></i>
            <span>Algoritma</span>
        </a>
        <div id="algoritmaDropdown" class="collapse" aria-labelledby="headingAlgoritma" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('algoritma.index') }}">
                    <i class="fas fa-brain"></i><samp> Algoritma</samp>
                </a>
                <a class="collapse-item" href="{{ route('rekomendasi.perbandingan') }}">
                    <i class="fas fa-cogs"></i><samp> Rekomendasi</samp>
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#dataDropdown"
            aria-expanded="false" aria-controls="dataDropdown">
            <i class="fas fa-fw fa-folder"></i>
            <span>Data Master</span>
        </a>
        <div id="dataDropdown" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('nilai.index') }}">
                    <i class="fas fa-table"></i><samp> Data Nilai</samp>
                </a>
                <a class="collapse-item" href="{{ route('students.index') }}">
                    <i class="fas fa-fw fa-users"></i><samp> Data Siswa</samp>
                </a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('violations.index') }}">
            <i class="fas fa-fw fa-exclamation-triangle"></i>
            <span>Pelanggaran</span>
        </a>
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

</ul>
