<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - {{ $plan->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
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

    <!-- Payment Section -->
    <section class="py-12">
        <div class="container mx-auto px-4 max-w-2xl">
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="mb-6">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-3xl text-blue-600"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Menunggu Pembayaran</h1>
                    <p class="text-gray-600">Silakan lanjutkan pembayaran Anda</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-2 gap-4 text-left mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Order ID</p>
                            <p class="font-semibold text-gray-800">{{ $transaction->midtrans_order_id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total Pembayaran</p>
                            <p class="font-bold text-blue-600 text-xl">Rp
                                {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Gym</p>
                            <p class="font-semibold text-gray-800">{{ $plan->gym->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Paket</p>
                            <p class="font-semibold text-gray-800">{{ $plan->name }}</p>
                        </div>
                    </div>

                    <div class="text-sm text-gray-600 border-t pt-4">
                        <i class="fas fa-clock mr-1"></i>
                        Batas waktu pembayaran: {{ $transaction->expired_at->format('d M Y H:i') }} WIB
                    </div>
                </div>

                <button id="pay-button"
                    class="w-full bg-blue-600 text-white py-4 rounded-lg font-bold text-lg hover:bg-blue-700 transition mb-4">
                    <i class="fas fa-lock mr-2"></i>
                    Bayar Sekarang
                </button>

                <p class="text-sm text-gray-500">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Pembayaran aman dengan Midtrans
                </p>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href =
                        '{{ route('checkout.thank-you') }}?order_id={{ $transaction->midtrans_order_id }}';
                },
                onPending: function(result) {
                    window.location.href =
                        '{{ route('checkout.thank-you') }}?order_id={{ $transaction->midtrans_order_id }}';
                },
                onError: function(result) {
                    alert('Pembayaran gagal, silakan coba lagi');
                    console.log(result);
                },
                onClose: function() {
                    alert('Anda menutup popup pembayaran sebelum menyelesaikan pembayaran');
                }
            });
        });

        // Auto trigger payment popup
        window.addEventListener('load', function() {
            setTimeout(function() {
                payButton.click();
            }, 500);
        });
    </script>
</body>

</html>
