<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Right side user nav -->
    <ul class="navbar-nav ml-auto">

        {{-- KNN Prediction Alert --}}
        @php
            use App\Models\Student;
            $pendingPrediction = Student::where('is_predicted', 0)->exists();
        @endphp

        @if ($pendingPrediction)
            <li class="nav-item mr-3 align-self-center">
                <a href="{{ route('keputusanAkhirKNN') }}" class="btn btn-warning btn-sm font-weight-bold"
                    onclick="return confirm('Ada data yang belum diprediksi ulang. Lanjutkan proses KNN?')">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Prediksi K-NN Diperlukan
                </a>
            </li>
        @endif

        <div class="topbar-divider d-none d-sm-block"></div>

        {{-- User Dropdown --}}
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                <img class="img-profile rounded-circle"
                    src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('img/undraw_profile_' . rand(1, 3) . '.svg') }}"
                    width="32" height="32">
                <div class="d-inline-block text-gray-600 small ml-2">
                    <span class="d-block">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <span class="d-block">{{ Auth::user()->email ?? 'guest@example.com' }}</span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
