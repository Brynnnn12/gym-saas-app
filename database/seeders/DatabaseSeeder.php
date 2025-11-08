<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Gym;
use App\Models\Plan;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan RolePermissionSeeder terlebih dahulu
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Buat super admin user
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gym-saas.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super_admin');

        // Buat gym owner users dan gyms mereka
        for ($i = 1; $i <= 3; $i++) {
            $gymOwner = User::factory()->create([
                'name' => "Gym Owner $i",
                'email' => "owner$i@gym-saas.com",
                'password' => bcrypt('password'),
            ]);
            $gymOwner->assignRole('gym_owner');

            // Buat gym untuk owner ini
            $gym = Gym::factory()->create([
                'user_id' => $gymOwner->id,
            ]);

            // Buat plans untuk gym ini
            Plan::factory()->count(4)->create([
                'gym_id' => $gym->id,
            ]);
        }

        // Buat members dengan subscriptions dan transactions
        $members = Member::factory()->count(20)->create();

        foreach ($members as $member) {
            // Member tidak perlu assign role karena bukan Authenticatable User

            // 70% member punya transaction dan subscription
            if (fake()->boolean(70)) {
                $plan = Plan::inRandomOrder()->first();

                // Buat transaction
                $transaction = Transaction::factory()->create([
                    'member_id' => $member->id,
                    'plan_id' => $plan->id,
                    'amount' => $plan->price,
                ]);

                // Jika transaction paid, buat subscription aktif
                if ($transaction->status === 'paid') {
                    Subscription::factory()->create([
                        'member_id' => $member->id,
                        'plan_id' => $plan->id,
                        'transaction_id' => $transaction->id,
                    ]);
                }
            }
        }
    }
}
