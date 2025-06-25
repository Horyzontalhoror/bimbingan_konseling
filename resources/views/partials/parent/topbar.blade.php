<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                <img class="img-profile rounded-circle"
                     src="{{ asset('img/undraw_profile_' . rand(1,3) . '.svg') }}"
                     width="32" height="32">

                <div class="d-inline-block text-gray-600 small ml-2">
                    <span class="d-block">
                        {{ Auth::guard('parent')->user()->name ?? 'Orang Tua' }}
                    </span>
                    <span class="d-block">
                        {{ Auth::guard('parent')->user()->email ?? '-' }}
                    </span>
                </div>
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                {{-- Jika ada fitur edit profil orang tua --}}
                {{-- <a class="dropdown-item" href="{{ route('parent.profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>
                <div class="dropdown-divider"></div> --}}

                <form action="{{ route('parent.logout') }}" method="POST">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
