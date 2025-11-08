<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gym - FitHub</title>
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
                    <a href="{{ route('gyms.index') }}" class="text-blue-600 font-semibold">Cari Gym</a>

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

    <!-- Header & Search -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-center mb-8">Temukan Gym Impian Anda</h1>

            <!-- Search Form -->
            <form method="GET" class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg p-6 shadow-lg">
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Pencarian</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Nama gym atau kota..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                <i class="fas fa-search absolute right-3 top-3.5 text-gray-400"></i>
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-2">Kota</label>
                            <select name="city"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700">
                                <option value="">Semua Kota</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city }}"
                                        {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-search mr-2"></i>Cari
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Results -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            <!-- Results Info -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $gyms->total() }} Gym Ditemukan
                    @if (request('search') || request('city'))
                        <span class="text-lg text-gray-600">untuk</span>
                        @if (request('search'))
                            <span class="text-blue-600">"{{ request('search') }}"</span>
                        @endif
                        @if (request('city'))
                            <span class="text-blue-600">di {{ request('city') }}</span>
                        @endif
                    @endif
                </h2>

                @if (request('search') || request('city'))
                    <a href="{{ route('gyms.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                        <i class="fas fa-times mr-1"></i>Reset Filter
                    </a>
                @endif
            </div>

            <!-- Gym Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($gyms as $gym)
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
                                    <span class="text-sm text-gray-500">Paket mulai dari:</span>
                                    <div class="text-2xl font-bold text-blue-600">
                                        Rp {{ number_format($gym->plans->min('price'), 0, ',', '.') }}
                                        <span
                                            class="text-sm text-gray-500 font-normal">/{{ $gym->plans->where('price', $gym->plans->min('price'))->first()->duration_months }}
                                            bulan</span>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $gym->plans->count() }} paket tersedia
                                    </div>
                                </div>
                            @endif

                            <a href="{{ route('gyms.show', $gym->slug) }}"
                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition inline-flex items-center justify-center">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat Detail & Paket
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada gym yang ditemukan</h3>
                        <p class="text-gray-500 mb-4">Coba ubah kata kunci pencarian atau filter kota</p>
                        <a href="{{ route('gyms.index') }}"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                            Lihat Semua Gym
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($gyms->hasPages())
                <div class="mt-12">
                    {{ $gyms->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <i class="fas fa-dumbbell text-xl text-blue-400"></i>
                <span class="text-xl font-bold">FitHub</span>
            </div>
            <p class="text-gray-400">&copy; 2025 FitHub. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
