<?php

namespace Database\Factories;

use App\Models\Gym;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $durations = [1, 3, 6, 12];
        $duration = fake()->randomElement($durations);
        $basePrice = [150000, 200000, 300000, 500000];

        $planNames = [
            1 => 'Paket Bulanan',
            3 => 'Paket 3 Bulan',
            6 => 'Paket 6 Bulan',
            12 => 'Paket Tahunan',
        ];

        return [
            'gym_id' => Gym::factory(),
            'name' => $planNames[$duration],
            'description' => fake()->sentence(10),
            'price' => fake()->randomElement($basePrice) * $duration,
            'duration_months' => $duration,
            'is_active' => fake()->boolean(90), // 90% aktif
        ];
    }
}
