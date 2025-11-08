<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $plan = Plan::factory()->create();
        $status = fake()->randomElement(['pending', 'paid', 'failed', 'cancelled']);
        $isPaid = $status === 'paid';

        return [
            'member_id' => Member::factory(),
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'status' => $status,
            'midtrans_order_id' => 'GYM-' . strtoupper(Str::random(8)) . '-' . time(),
            'midtrans_transaction_id' => $isPaid ? 'TRX-' . strtoupper(Str::random(10)) : null,
            'payment_method' => $isPaid ? fake()->randomElement(['credit_card', 'bank_transfer', 'gopay', 'ovo']) : null,
            'paid_at' => $isPaid ? fake()->dateTimeBetween('-30 days', 'now') : null,
            'expired_at' => !$isPaid ? fake()->dateTimeBetween('now', '+1 day') : null,
        ];
    }
}
