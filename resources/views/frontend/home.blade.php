<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FitHub - Platform Gym Membership Terbaik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-dumbbell text-2xl text-blue-600"></i>
                    <span class="text-2xl font-bold text-gray-800">FitHub</span>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 transition">Home</a>
                    <a href="{{ route('gyms.index') }}" class="text-gray-700 hover:text-blue-600 transition">Cari
                        Gym</a>

                    @if (session('member_id'))
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-700">
                                <i class="fas fa-user-circle mr-1"></i>{{ session('member_name') }}
                            </span>
                            <form action="{{ route('member.logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('member.login') }}" class="text-gray-700 hover:text-blue-600 transition">
                            <i class="fas fa-sign-in-alt mr-1"></i>Login
                        </a>
                        <a href="{{ route('member.register') }}"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-user-plus mr-1"></i>Daftar
                        </a>
                    @endif
                </div>
                <div class="md:hidden">
                    <button class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">Temukan Gym Terbaik di Kota Anda</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Bergabunglah dengan ribuan member yang sudah merasakan pengalaman
                fitness terbaik di gym-gym pilihan</p>
            <a href="{{ route('gyms.index') }}"
                class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition inline-flex items-center">
                <i class="fas fa-search mr-2"></i>
                Mulai Cari Gym
            </a>
        </div>
    </section>

    <!-- Featured Gyms -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Gym Populer</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Gym-gym pilihan terbaik dengan fasilitas lengkap dan harga
                    terjangkau</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($featuredGyms as $gym)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 relative">
                            @if ($gym->image)
                                <img src="{{ Storage::url($gym->image) }}" alt="{{ $gym->name }}"
                                    class="w-full h-full object-cover">
                            @endif
                            @if ($gym->plans->where('price', '<', 200000)->count() > 0)
                                <div class="absolute top-4 right-4">
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-fire mr-1"></i>Promo
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $gym->name }}</h3>
                            <p class="text-gray-600 mb-3 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                                {{ $gym->city }}
                            </p>
                            <p class="text-gray-700 mb-4 line-clamp-2">{{ $gym->description }}</p>

                            @if ($gym->plans->count() > 0)
                                <div class="mb-4">
                                    <span class="text-sm text-gray-500">Mulai dari:</span>
                                    <div class="text-2xl font-bold text-blue-600">
                                        Rp {{ number_format($gym->plans->min('price'), 0, ',', '.') }}
                                        <span class="text-sm text-gray-500 font-normal">/bulan</span>
                                    </div>
                                </div>
                            @endif

                            <a href="{{ route('gyms.show', $gym->slug) }}"
                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition inline-flex items-center justify-center">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('gyms.index') }}"
                    class="bg-gray-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-700 transition inline-flex items-center">
                    Lihat Semua Gym
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Mengapa Pilih FitHub?</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Pencarian Mudah</h3>
                    <p class="text-gray-600">Temukan gym terdekat dengan mudah berdasarkan lokasi dan preferensi Anda
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Pembayaran Aman</h3>
                    <p class="text-gray-600">Sistem pembayaran terintegrasi dengan berbagai metode pembayaran yang aman
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Gym Berkualitas</h3>
                    <p class="text-gray-600">Hanya gym-gym terpilih dengan fasilitas lengkap dan instruktur
                        berpengalaman</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-dumbbell text-2xl text-blue-400"></i>
                        <span class="text-2xl font-bold">FitHub</span>
                    </div>
                    <p class="text-gray-400">Platform terbaik untuk menemukan gym impian Anda di seluruh Indonesia.</p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('gyms.index') }}"
                                class="text-gray-400 hover:text-white transition">Cari
                                Gym</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition text-xl">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-xl">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-xl">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2025 FitHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
