<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function createSnapToken($orderId, $grossAmount, $customerDetails, $itemDetails)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('checkout.thank-you'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            throw new \Exception('Error creating snap token: ' . $e->getMessage());
        }
    }

    public function getTransactionStatus($orderId)
    {
        try {
            $status = MidtransTransaction::status($orderId);
            return $status;
        } catch (\Exception $e) {
            throw new \Exception('Error getting transaction status: ' . $e->getMessage());
        }
    }

    public function handleNotification($notification)
    {
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status ?? null;

        $status = 'pending';

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $status = 'paid';
            }
        } elseif ($transactionStatus == 'settlement') {
            $status = 'paid';
        } elseif ($transactionStatus == 'pending') {
            $status = 'pending';
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $status = 'failed';
        }

        return $status;
    }
}
