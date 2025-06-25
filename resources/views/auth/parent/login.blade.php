<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Orang Tua</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <form method="POST" action="{{ route('parent.login.submit') }}" class="bg-white p-6 rounded shadow-md w-full max-w-sm">
        @csrf

        <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Login Orang Tua</h2>

        @if (session('error'))
            <div class="mb-4 text-red-600 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email"
                   class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-900 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="email@example.com" required autofocus>
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

</body>
</html>
