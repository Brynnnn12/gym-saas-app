<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Plan;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $plan = Plan::factory()->create();
        $startedAt = fake()->dateTimeBetween('-6 months', 'now');
        $activeUntil = Carbon::parse($startedAt)->addMonths($plan->duration_months);
        $isActive = $activeUntil > now();

        return [
            'member_id' => Member::factory(),
            'plan_id' => $plan->id,
            'transaction_id' => Transaction::factory(),
            'started_at' => $startedAt,
            'active_until' => $activeUntil,
            'is_active' => $isActive,
        ];
    }
}
