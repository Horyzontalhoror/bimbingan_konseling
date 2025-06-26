<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-sm bg-white p-6 rounded shadow-md">

            <!-- Logo -->
            <div class="text-center mb-6">
                <a href="/">
                    <img src="{{ asset('favicon/favicon.svg') }}" alt="Logo" class="w-32 mx-auto my-4">
                </a>
            </div>

            <form method="POST" action="{{ route('student.login.submit') }}">
                @csrf

                <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Login Siswa</h2>

                @if (session('error'))
                    <div class="mb-4 text-red-600 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- NISN -->
                <div class="mb-4">
                    <label for="nisn" class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                    <input type="text" name="nisn" id="nisn"
                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Masukkan NISN" required autofocus>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="********" required>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-4">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
