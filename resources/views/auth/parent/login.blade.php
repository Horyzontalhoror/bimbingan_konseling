<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Orang Tua - SMP Negeri 1 Solor Barat</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom background gradient for a softer look */
        body {
            background: linear-gradient(to bottom right, #f0f4f8, #e2e8f0);
            /* Soft light gradient */
        }

        .dark body {
            background: linear-gradient(to bottom right, #2d3748, #1a202c);
            /* Dark gradient */
        }

        /* Custom focus ring for consistency (override Tailwind's default if needed) */
        input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 45, 32, 0.3);
            /* Custom primary color ring */
            border-color: #FF2D20;
            /* Primary border color on focus */
        }

        /* Ensure placeholder text is visible in dark mode */
        .dark input::placeholder {
            color: #a0aec0;
            /* Lighter gray for dark mode placeholders */
        }
    </style>
</head>

<body class="font-sans text-gray-900 dark:text-gray-100 antialiased min-h-screen flex items-center justify-center">

    <div
        class="w-full max-w-sm md:max-w-md bg-white dark:bg-zinc-800 p-8 md:p-10 rounded-xl shadow-2xl transition-all duration-300 ease-in-out transform hover:scale-[1.01]">

        <div class="text-center mb-8">
            <a href="/" class="block">
                {{-- Mengurangi ukuran logo agar tidak terlalu besar dan responsif --}}
                <img src="{{ asset('favicon/favicon.svg') }}" alt="Logo SMPN 1 Solor Barat"
                    class="w-24 md:w-32 mx-auto mb-4 transition-transform duration-300 hover:scale-105">
            </a>
            <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white mb-2">Login Orang Tua</h1>
            <p class="text-gray-600 dark:text-gray-400 text-md">Akses portal orang tua siswa Anda</p>
        </div>

        <form method="POST" action="{{ route('parent.login.submit') }}">
            @csrf

            @if (session('error'))
                <div class="bg-red-50 dark:bg-red-800 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-100 px-4 py-3 rounded-lg relative mb-6 animate-fade-in"
                    role="alert">
                    <strong class="font-bold">Login Gagal!</strong>
                    <span class="block sm:inline ml-2">{{ session('error') }}</span>
                    {{-- Tombol close ini memerlukan JS untuk fungsionalitasnya --}}
                    <button type="button"
                        class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-500 dark:text-red-200"
                        onclick="this.closest('[role=alert]').style.display='none';">
                        <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.107l-2.651 3.742a1.2 1.2 0 1 1-1.697-1.697l3.742-2.651-3.742-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.893l2.651-3.742a1.2 1.2 0 1 1 1.697 1.697L11.107 10l3.742 2.651a1.2 1.2 0 0 1 0 1.697z" />
                        </svg>
                    </button>
                </div>
            @endif

            <div class="mb-5">
                <label for="email"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                <input type="email" name="email" id="email"
                    class="w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-gray-200 rounded-lg p-3 text-base shadow-sm focus:border-primary focus:ring-primary transition-all duration-200 ease-in-out placeholder-gray-400 dark:placeholder-gray-500"
                    placeholder="email@example.com" required autofocus autocomplete="email">
            </div>

            <div class="mb-6">
                <label for="password"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                <input type="password" name="password" id="password"
                    class="w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-gray-200 rounded-lg p-3 text-base shadow-sm focus:border-primary focus:ring-primary transition-all duration-200 ease-in-out placeholder-gray-400 dark:placeholder-gray-500"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required
                    autocomplete="current-password">
            </div>

            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary dark:bg-zinc-700 dark:border-zinc-600 transition-colors duration-200 checked:bg-primary checked:border-transparent">
                    <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-gray-400 select-none">Ingat
                        saya</label>
                </div>
                {{-- Uncomment if you have a forgot password route for parents --}}
                {{--
                @if (Route::has('parent.password.request'))
                    <a href="{{ route('parent.password.request') }}" class="text-sm text-primary hover:underline dark:text-primary-lighter">Lupa Password?</a>
                @endif
                --}}
            </div>

            <button type="submit"
                class="w-full bg-primary hover:bg-red-700 text-white font-semibold py-3 rounded-lg text-lg shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-primary/50 dark:focus:ring-primary/60">
                Login
            </button>
        </form>

        <div class="mt-8 text-center text-gray-600 dark:text-gray-400 text-sm">
            Belum punya akun? Hubungi Admin Sekolah.
            {{-- Uncomment if you have a parent registration route --}}
            {{-- <a href="{{ route('parent.register') }}" class="text-primary hover:underline">Daftar Sekarang</a> --}}
        </div>
    </div>
</body>

</html>
