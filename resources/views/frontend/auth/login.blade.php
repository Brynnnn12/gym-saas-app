<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Member - FitHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .floating-label {
            transition: all 0.2s ease;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-40 -right-40 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute top-40 left-40 w-80 h-80 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000">
        </div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo & Back -->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}"
                class="inline-flex items-center text-white hover:text-opacity-80 mb-6 transition-all duration-300 hover:translate-x-[-4px]">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Beranda
            </a>
            <div class="flex items-center justify-center space-x-3 mb-3">
                <div class="bg-white bg-opacity-20 p-3 rounded-2xl backdrop-blur-sm">
                    <i class="fas fa-dumbbell text-4xl text-white"></i>
                </div>
                <h1 class="text-5xl font-bold text-white drop-shadow-lg">FitHub</h1>
            </div>
            <p class="text-white text-opacity-90 text-lg">Selamat datang kembali! 💪</p>
        </div>

        <!-- Login Card -->
        <div class="glass-effect rounded-3xl shadow-2xl p-8 border border-white border-opacity-20">
            <div class="text-center mb-8">
                <h2
                    class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">
                    Login Member
                </h2>
                <p class="text-gray-600">Masuk untuk melanjutkan ke dashboard Anda</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6 animate-shake">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle mt-1 mr-3"></i>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('member.login') }}" class="space-y-5">
                @csrf

                <div class="relative">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm">
                        Email Address
                    </label>
                    <div class="relative">
                        <span class="input-icon text-purple-600">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-10 pr-4 py-3 border-2 @error('email') border-red-400 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300"
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div class="relative">
                    <label class="block text-gray-700 font-semibold mb-2 text-sm">
                        Password
                    </label>
                    <div class="relative">
                        <span class="input-icon text-purple-600">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-10 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-300"
                            placeholder="••••••••">
                        <span class="password-toggle text-gray-400 hover:text-purple-600" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center group cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500 cursor-pointer">
                        <span class="ml-2 text-sm text-gray-600 group-hover:text-purple-600 transition">Ingat
                            saya</span>
                    </label>
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-800 transition font-semibold">
                        Lupa password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-4 rounded-xl font-bold text-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8">
                <div class="text-center mb-6">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('member.register') }}"
                            class="text-purple-600 hover:text-purple-800 font-bold transition-all duration-300 hover:underline">
                            Daftar Sekarang →
                        </a>
                    </p>
                </div>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Atau masuk dengan</span>
                    </div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-2 gap-4">
                    <button type="button"
                        class="flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-xl hover:border-purple-300 hover:bg-purple-50 transition-all duration-300 group">
                        <i
                            class="fab fa-google text-red-500 mr-2 text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold text-gray-700">Google</span>
                    </button>
                    <button type="button"
                        class="flex items-center justify-center px-4 py-3 border-2 border-gray-200 rounded-xl hover:border-blue-300 hover:bg-blue-50 transition-all duration-300 group">
                        <i
                            class="fab fa-facebook text-blue-600 mr-2 text-lg group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold text-gray-700">Facebook</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-white text-sm space-y-2">
            <p class="text-opacity-90">
                <i class="fas fa-shield-alt mr-1"></i>
                Keamanan data Anda adalah prioritas kami
            </p>
            <p class="text-opacity-75">
                &copy; 2025 FitHub. All rights reserved.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Animation for floating elements
        const style = document.createElement('style');
        style.textContent = `
            @keyframes blob {
                0%, 100% { transform: translate(0, 0) scale(1); }
                25% { transform: translate(20px, -50px) scale(1.1); }
                50% { transform: translate(-20px, 20px) scale(0.9); }
                75% { transform: translate(50px, 50px) scale(1.05); }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                20%, 40%, 60%, 80% { transform: translateX(5px); }
            }
            .animate-shake {
                animation: shake 0.5s;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>
