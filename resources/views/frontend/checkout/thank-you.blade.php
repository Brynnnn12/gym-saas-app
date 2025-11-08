<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - FitHub</title>
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

    <!-- Thank You Section -->
    <section class="py-12">
        <div class="container mx-auto px-4 max-w-3xl">
            @if ($transaction->status === 'paid')
                <!-- Success -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="mb-6">
                        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-5xl text-green-600"></i>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
                        <p class="text-gray-600 text-lg">Terima kasih telah bergabung dengan
                            {{ $transaction->plan->gym->name }}</p>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                        <div class="grid md:grid-cols-2 gap-4 text-left">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Order ID</p>
                                <p class="font-semibold text-gray-800">{{ $transaction->midtrans_order_id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Tanggal Pembayaran</p>
                                <p class="font-semibold text-gray-800">{{ $transaction->paid_at->format('d M Y H:i') }}
                                    WIB</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Metode Pembayaran</p>
                                <p class="font-semibold text-gray-800">
                                    {{ strtoupper($transaction->payment_method ?? '-') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Dibayar</p>
                                <p class="font-bold text-green-600 text-xl">Rp
                                    {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    @if ($transaction->subscription)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6 text-left">
                            <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-id-card text-blue-600 mr-2"></i>
                                Informasi Membership
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nama Member</span>
                                    <span class="font-semibold text-gray-800">{{ $transaction->member->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email</span>
                                    <span class="font-semibold text-gray-800">{{ $transaction->member->email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Paket</span>
                                    <span class="font-semibold text-gray-800">{{ $transaction->plan->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Masa Aktif</span>
                                    <span class="font-semibold text-gray-800">
                                        {{ $transaction->subscription->started_at->format('d M Y') }} -
                                        {{ $transaction->subscription->active_until->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status</span>
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i>Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h3 class="font-bold text-gray-800 mb-4 text-left">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            Langkah Selanjutnya
                        </h3>
                        <ol class="text-left space-y-3 text-gray-700">
                            <li class="flex items-start">
                                <span
                                    class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center mr-3 mt-0.5 text-sm flex-shrink-0">1</span>
                                <span>Cek email <strong>{{ $transaction->member->email }}</strong> untuk konfirmasi dan
                                    detail membership Anda</span>
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center mr-3 mt-0.5 text-sm flex-shrink-0">2</span>
                                <span>Datang ke <strong>{{ $transaction->plan->gym->name }}</strong> di
                                    {{ $transaction->plan->gym->address }}</span>
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center mr-3 mt-0.5 text-sm flex-shrink-0">3</span>
                                <span>Tunjukkan email konfirmasi atau Order ID untuk aktivasi membership Anda</span>
                            </li>
                            <li class="flex items-start">
                                <span
                                    class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center mr-3 mt-0.5 text-sm flex-shrink-0">4</span>
                                <span>Mulai latihan dan raih target fitness Anda!</span>
                            </li>
                        </ol>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('home') }}"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition inline-block">
                            <i class="fas fa-home mr-2"></i>
                            Kembali ke Beranda
                        </a>
                        <p class="text-sm text-gray-500">
                            Butuh bantuan? Hubungi <strong>{{ $transaction->plan->gym->phone }}</strong>
                        </p>
                    </div>
                </div>
            @elseif($transaction->status === 'pending')
                <!-- Pending -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="mb-6">
                        <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clock text-5xl text-yellow-600"></i>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Menunggu Pembayaran</h1>
                        <p class="text-gray-600 text-lg">Segera selesaikan pembayaran Anda</p>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                        <div class="grid md:grid-cols-2 gap-4 text-left">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Order ID</p>
                                <p class="font-semibold text-gray-800">{{ $transaction->midtrans_order_id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                                <p class="font-bold text-yellow-600 text-xl">Rp
                                    {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-600 mb-1">Batas Waktu</p>
                                <p class="font-semibold text-red-600">
                                    {{ $transaction->expired_at->format('d M Y H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6 text-left">
                        <h3 class="font-bold text-gray-800 mb-3">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            Cara Menyelesaikan Pembayaran
                        </h3>
                        <ol class="space-y-2 text-gray-700">
                            <li>1. Cek email untuk instruksi pembayaran</li>
                            <li>2. Selesaikan pembayaran sebelum batas waktu</li>
                            <li>3. Membership akan otomatis aktif setelah pembayaran berhasil</li>
                        </ol>
                    </div>

                    <a href="{{ route('home') }}"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition inline-block">
                        <i class="fas fa-home mr-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            @else
                <!-- Failed -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <div class="mb-6">
                        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-times-circle text-5xl text-red-600"></i>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Gagal</h1>
                        <p class="text-gray-600 text-lg">Transaksi Anda tidak dapat diproses</p>
                    </div>

                    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                        <p class="text-gray-700 mb-2">Order ID: <strong>{{ $transaction->midtrans_order_id }}</strong>
                        </p>
                        <p class="text-gray-700">Status: <span
                                class="text-red-600 font-semibold">{{ strtoupper($transaction->status) }}</span></p>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('gyms.show', $transaction->plan->gym->slug) }}"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition inline-block">
                            <i class="fas fa-redo mr-2"></i>
                            Coba Lagi
                        </a>
                        <a href="{{ route('home') }}"
                            class="w-full bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-300 transition inline-block">
                            <i class="fas fa-home mr-2"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            @endif
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
