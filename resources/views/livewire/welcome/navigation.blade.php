<nav class="-mx-3 flex flex-1 justify-end space-x-2">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Dashboard
        </a>
    @else
        <!-- Login Guru BK (default Laravel login) -->
        <a
            href="{{ route('login') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-red dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Login Guru BK
        </a>

        <!-- Login Siswa -->
        <a
            href="{{ route('student.login') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-red dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Login Siswa
        </a>

        <!-- Login Orang Tua -->
        <a
            href="{{ route('parent.login') }}"
            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-red dark:hover:text-white/80 dark:focus-visible:ring-white"
        >
            Login Orang Tua
        </a>

        @if (Route::has('register'))
            {{-- <a
                href="{{ route('register') }}"
                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-red dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
                Register
            </a> --}}
        @endif
    @endauth
</nav>
