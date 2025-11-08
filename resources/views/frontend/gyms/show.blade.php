<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $gym->name }} - FitHub</title>
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
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-800">FitHub</a>
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
            </div>
        </div>
    </nav>

    <!-- Gym Header -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="flex items-center mb-4">
                <a href="{{ route('gyms.index') }}" class="text-white hover:text-blue-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Gym
                </a>
            </div>

            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h1 class="text-4xl font-bold mb-4">{{ $gym->name }}</h1>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-map-marker-alt text-xl mr-3"></i>
                        <div>
                            <p class="text-lg font-semibold">{{ $gym->city }}</p>
                            <p class="text-blue-100">{{ $gym->address }}</p>
                        </div>
                    </div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-phone text-xl mr-3"></i>
                        <p class="text-lg">{{ $gym->phone }}</p>
                    </div>
                </div>

                @if ($gym->image)
                    <div class="rounded-lg overflow-hidden shadow-2xl">
                        <img src="{{ Storage::url($gym->image) }}" alt="{{ $gym->name }}"
                            class="w-full h-80 object-cover">
                    </div>
                @else
                    <div class="bg-white/10 rounded-lg h-80 flex items-center justify-center">
                        <i class="fas fa-dumbbell text-6xl text-white/50"></i>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Gym Description -->
    <section class="py-8 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Tentang Gym</h2>
            <p class="text-gray-700 text-lg leading-relaxed">{{ $gym->description }}</p>
        </div>
    </section>

    <!-- Membership Plans -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-2 text-center">Paket Membership</h2>
            <p class="text-gray-600 text-center mb-8">Pilih paket yang sesuai dengan kebutuhan Anda</p>

            @if ($gym->plans->where('is_active', true)->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($gym->plans->where('is_active', true)->sortBy('price') as $plan)
                        <div
                            class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 {{ $loop->index == 1 ? 'border-2 border-blue-500 relative' : '' }}">
                            @if ($loop->index == 1)
                                <div class="bg-blue-500 text-white text-center py-2 font-semibold">
                                    <i class="fas fa-star mr-1"></i>Paling Populer
                                </div>
                            @endif

                            <div class="p-6">
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $plan->name }}</h3>
                                <p class="text-gray-600 mb-4">{{ $plan->description }}</p>

                                <div class="mb-6">
                                    <div class="text-4xl font-bold text-blue-600 mb-1">
                                        Rp {{ number_format($plan->price, 0, ',', '.') }}
                                    </div>
                                    <div class="text-gray-500">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $plan->duration_months }} bulan
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        Rp
                                        {{ number_format($plan->price / $plan->duration_months, 0, ',', '.') }}/bulan
                                    </div>
                                </div>

                                <!-- Plan Features -->
                                <div class="mb-6 space-y-2">
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span>Akses semua fasilitas gym</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span>Loker pribadi</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span>Konsultasi trainer</span>
                                    </div>
                                    @if ($plan->duration_months >= 6)
                                        <div class="flex items-center text-gray-700">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span>1x Free Personal Training</span>
                                        </div>
                                    @endif
                                    @if ($plan->duration_months >= 12)
                                        <div class="flex items-center text-gray-700">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span>Free Guest Pass (2x)</span>
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ route('checkout.show', $plan->id) }}"
                                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition inline-flex items-center justify-center {{ $loop->index == 1 ? 'bg-blue-700' : '' }}">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Daftar Sekarang
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-exclamation-circle text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Paket Tersedia</h3>
                    <p class="text-gray-500">Gym ini sedang mempersiapkan paket membership. Silakan cek kembali nanti.
                    </p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-12">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Siap Memulai Perjalanan Fitness Anda?</h2>
            <p class="text-xl mb-8">Bergabunglah dengan {{ $gym->name }} sekarang dan wujudkan target fitness Anda!
            </p>
            @if ($gym->plans->where('is_active', true)->count() > 0)
                <a href="#paket"
                    onclick="window.scrollTo({top: document.querySelector('section:nth-of-type(3)').offsetTop, behavior: 'smooth'})"
                    class="bg-white text-blue-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition inline-block">
                    <i class="fas fa-arrow-up mr-2"></i>Lihat Paket Membership
                </a>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-dumbbell text-xl text-blue-400"></i>
                        <span class="text-xl font-bold">FitHub</span>
                    </div>
                    <p class="text-gray-400">Platform terpercaya untuk menemukan dan berlangganan gym terbaik di
                        Indonesia.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Tentang Kami</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Cara Kerja</a></li>
                        <li><a href="#" class="hover:text-white transition">Partnership</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Link Cepat</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('gyms.index') }}" class="hover:text-white transition">Cari Gym</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Hubungi Kami</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-envelope mr-2"></i>support@fithub.com</li>
                        <li><i class="fas fa-phone mr-2"></i>+62 812-3456-7890</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center text-gray-400">
                <p>&copy; 2025 FitHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
