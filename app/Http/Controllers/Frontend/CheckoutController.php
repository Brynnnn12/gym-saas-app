<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function show(Plan $plan)
    {
        $plan->load('gym');

        // Get member data if logged in
        $member = null;
        if (session('member_id')) {
            $member = Member::find(session('member_id'));
        }

        return view('frontend.checkout.show', compact('plan', 'member'));
    }

    public function process(Request $request, Plan $plan)
    {
        // If member is logged in, use their data
        if (session('member_id')) {
            $member = Member::find(session('member_id'));

            // Update member data if provided
            if ($request->filled('phone')) {
                $member->update(['phone' => $request->phone]);
            }
        } else {
            // Validate for new member
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'birth_date' => 'required|date|before:today',
                'gender' => 'required|in:male,female',
                'password' => 'required|string|min:8|confirmed',
            ]);

            try {
                DB::beginTransaction();

                // Check if member already exists
                $member = Member::where('email', $validated['email'])->first();

                if (!$member) {
                    // Create new member
                    $member = Member::create([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'birth_date' => $validated['birth_date'],
                        'gender' => $validated['gender'],
                        'password' => Hash::make($validated['password']),
                    ]);
                }

                // Auto login new member
                session(['member_id' => $member->id]);
                session(['member_name' => $member->name]);
                session(['member_email' => $member->email]);
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Terjadi kesalahan saat membuat akun: ' . $e->getMessage());
            }
        }

        try {
            DB::beginTransaction();

            // Create transaction
            $orderId = 'TRX-' . strtoupper(Str::random(10)) . '-' . time();

            $transaction = Transaction::create([
                'member_id' => $member->id,
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'status' => 'pending',
                'midtrans_order_id' => $orderId,
                'expired_at' => now()->addHours(24),
            ]);

            // Prepare Midtrans data
            $customerDetails = [
                'first_name' => $member->name,
                'email' => $member->email,
                'phone' => $member->phone,
            ];

            $itemDetails = [
                [
                    'id' => $plan->id,
                    'price' => $plan->price,
                    'quantity' => 1,
                    'name' => $plan->name . ' - ' . $plan->gym->name,
                ]
            ];

            // Get Snap Token
            $snapToken = $this->midtransService->createSnapToken(
                $orderId,
                $plan->price,
                $customerDetails,
                $itemDetails
            );

            DB::commit();

            return view('frontend.checkout.payment', compact('transaction', 'snapToken', 'plan'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        try {
            $notification = $request->all();
            $orderId = $notification['order_id'] ?? null;

            if (!$orderId) {
                return response()->json(['message' => 'Order ID not found'], 400);
            }

            $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

            if (!$transaction) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Get transaction status from Midtrans
            $midtransStatus = $this->midtransService->getTransactionStatus($orderId);

            // Update transaction
            $status = $this->midtransService->handleNotification($midtransStatus);

            $transaction->update([
                'status' => $status,
                'midtrans_transaction_id' => $midtransStatus->transaction_id ?? null,
                'payment_method' => $midtransStatus->payment_type ?? null,
                'paid_at' => $status === 'paid' ? now() : null,
            ]);

            // If paid, create subscription
            if ($status === 'paid') {
                $plan = $transaction->plan;

                Subscription::create([
                    'member_id' => $transaction->member_id,
                    'plan_id' => $transaction->plan_id,
                    'transaction_id' => $transaction->id,
                    'started_at' => now(),
                    'active_until' => now()->addMonths($plan->duration_months),
                    'is_active' => true,
                ]);
            }

            return response()->json(['message' => 'Notification processed']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function thankYou(Request $request)
    {
        $orderId = $request->query('order_id');

        if (!$orderId) {
            return redirect()->route('home');
        }

        $transaction = Transaction::where('midtrans_order_id', $orderId)
            ->with(['plan.gym', 'member'])
            ->first();

        if (!$transaction) {
            return redirect()->route('home');
        }

        return view('frontend.checkout.thank-you', compact('transaction'));
    }
}
