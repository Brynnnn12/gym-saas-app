<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Member - FitHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body
    class="bg-gradient-to-br from-blue-600 via-purple-600 to-pink-500 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo & Back -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-white hover:text-blue-100 mb-6">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
            <div class="flex items-center justify-center space-x-3 mb-2">
                <i class="fas fa-dumbbell text-4xl text-white"></i>
                <h1 class="text-4xl font-bold text-white">FitHub</h1>
            </div>
            <p class="text-blue-100">Login untuk mengakses membership Anda</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Login Member</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('member.login') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                            placeholder="nama@email.com">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>Password
                        </label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Masukkan password">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition">Lupa
                            password?</a>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-bold text-lg hover:from-blue-700 hover:to-purple-700 transition transform hover:scale-105 shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('member.register') }}"
                        class="text-blue-600 hover:text-blue-800 font-semibold transition">
                        Daftar Sekarang
                    </a>
                </p>
            </div>

            <!-- Social Login (Optional) -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Atau login dengan</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <button
                        class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i class="fab fa-google text-red-500 mr-2"></i>
                        Google
                    </button>
                    <button
                        class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i>
                        Facebook
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-white text-sm mt-8">
            &copy; 2025 FitHub. All rights reserved.
        </p>
    </div>
</body>

</html>
