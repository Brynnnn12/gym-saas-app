<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $plan->name }}</title>
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
            </div>
        </div>
    </nav>

    <!-- Checkout Form -->
    <section class="py-12">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="mb-8">
                <a href="{{ route('gyms.show', $plan->gym->slug) }}" class="text-blue-600 hover:underline">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke {{ $plan->gym->name }}
                </a>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Data Member</h2>

                        <form method="POST" action="{{ route('checkout.process', $plan->id) }}">
                            @csrf

                            <div class="space-y-4">
                                @if ($member)
                                    <!-- Member sudah login - tampilkan info -->
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-gray-600">Checkout sebagai:</p>
                                                <p class="font-bold text-gray-800">{{ $member->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $member->email }}</p>
                                            </div>
                                            <i class="fas fa-user-check text-3xl text-blue-600"></i>
                                        </div>
                                    </div>

                                    <!-- Optional: Update phone if needed -->
                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">
                                            Nomor Telepon <span class="text-sm text-gray-500">(opsional - untuk
                                                update)</span>
                                        </label>
                                        <input type="tel" name="phone" value="{{ old('phone', $member->phone) }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah</p>
                                    </div>
                                @else
                                    <!-- Member belum login - tampilkan form lengkap -->
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                        <div class="flex items-start">
                                            <i class="fas fa-info-circle text-yellow-600 mr-3 mt-1"></i>
                                            <div>
                                                <p class="text-sm text-gray-700">
                                                    Sudah punya akun?
                                                    <a href="{{ route('member.login') }}?redirect={{ urlencode(route('checkout.show', $plan->id)) }}"
                                                        class="text-blue-600 hover:underline font-semibold">
                                                        Login disini
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ old('name') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
                                        @error('name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                                        @error('email')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Nomor Telepon</label>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                                        @error('phone')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Tanggal Lahir</label>
                                        <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('birth_date') border-red-500 @enderror">
                                        @error('birth_date')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
                                        <select name="gender" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('gender') border-red-500 @enderror">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                Perempuan</option>
                                        </select>
                                        @error('gender')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Password</label>
                                        <input type="password" name="password" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                                        <p class="text-gray-500 text-sm mt-1">Minimal 8 karakter untuk akses member area
                                        </p>
                                        @error('password')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 font-semibold mb-2">Konfirmasi
                                            Password</label>
                                        <input type="password" name="password_confirmation" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                @endif

                                <div class="pt-4">
                                    <button type="submit"
                                        class="w-full bg-blue-600 text-white py-4 rounded-lg font-bold text-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-credit-card mr-2"></i>
                                        Lanjut ke Pembayaran
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Pesanan</h3>

                        <div class="mb-4">
                            <div class="text-sm text-gray-500 mb-1">Gym</div>
                            <div class="font-semibold text-gray-800">{{ $plan->gym->name }}</div>
                            <div class="text-sm text-gray-600">{{ $plan->gym->city }}</div>
                        </div>

                        <div class="mb-4 pb-4 border-b">
                            <div class="text-sm text-gray-500 mb-1">Paket</div>
                            <div class="font-semibold text-gray-800">{{ $plan->name }}</div>
                            <div class="text-sm text-gray-600">{{ $plan->duration_months }} bulan</div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-gray-700">
                                <span>Harga</span>
                                <span class="font-semibold">Rp {{ number_format($plan->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Biaya Admin</span>
                                <span class="font-semibold">Rp 0</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-700 font-semibold">Total</span>
                                <span class="text-2xl font-bold text-blue-600">Rp
                                    {{ number_format($plan->price, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-sm text-gray-500">
                                Rp {{ number_format($plan->price / $plan->duration_months, 0, ',', '.') }}/bulan
                            </p>
                        </div>

                        <div class="mt-6 pt-6 border-t">
                            <div class="flex items-start space-x-2 text-sm text-gray-600">
                                <i class="fas fa-shield-alt text-blue-600 mt-1"></i>
                                <div>
                                    <p class="font-semibold text-gray-700 mb-1">Pembayaran Aman</p>
                                    <p>Transaksi Anda dilindungi dengan enkripsi SSL dan sistem keamanan Midtrans</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
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
