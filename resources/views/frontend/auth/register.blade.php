<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member - FitHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body
    class="bg-gradient-to-br from-blue-600 via-purple-600 to-pink-500 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl">
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
            <p class="text-blue-100">Daftar dan mulai perjalanan fitness Anda</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Daftar Member Baru</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('member.register') }}">
                @csrf

                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user mr-2 text-blue-600"></i>Nama Lengkap
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="John Doe">
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="john@example.com">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-phone mr-2 text-blue-600"></i>Nomor Telepon
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="081234567890">
                    </div>

                    <!-- Birth Date -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>Tanggal Lahir
                        </label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    <!-- Gender -->
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-venus-mars mr-2 text-blue-600"></i>Jenis Kelamin
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label
                                class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="radio" name="gender" value="male"
                                    {{ old('gender') == 'male' ? 'checked' : '' }} required
                                    class="w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-700 font-medium">
                                    <i class="fas fa-mars text-blue-600 mr-2"></i>Laki-laki
                                </span>
                            </label>
                            <label
                                class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="radio" name="gender" value="female"
                                    {{ old('gender') == 'female' ? 'checked' : '' }} required
                                    class="w-4 h-4 text-blue-600">
                                <span class="ml-3 text-gray-700 font-medium">
                                    <i class="fas fa-venus text-pink-600 mr-2"></i>Perempuan
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>Password
                        </label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Minimal 8 karakter">
                        <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Ulangi password">
                    </div>

                    <!-- Terms -->
                    <div class="md:col-span-2">
                        <label class="flex items-start">
                            <input type="checkbox" required
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1">
                            <span class="ml-2 text-sm text-gray-600">
                                Saya setuju dengan <a href="#" class="text-blue-600 hover:underline">Syarat &
                                    Ketentuan</a> dan <a href="#" class="text-blue-600 hover:underline">Kebijakan
                                    Privasi</a>
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="md:col-span-2">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-bold text-lg hover:from-blue-700 hover:to-purple-700 transition transform hover:scale-105 shadow-lg">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar Sekarang
                        </button>
                    </div>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('member.login') }}"
                        class="text-blue-600 hover:text-blue-800 font-semibold transition">
                        Login Disini
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-white text-sm mt-8">
            &copy; 2025 FitHub. All rights reserved.
        </p>
    </div>
</body>

</html>
