<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Gym permissions
            'manage_all_gyms',
            'manage_own_gym',
            'view_gym',

            // Plan permissions
            'manage_all_plans',
            'manage_own_plans',
            'view_plan',

            // Member permissions
            'manage_all_members',
            'view_all_members',
            'view_own_profile',

            // Transaction permissions
            'manage_all_transactions',
            'view_all_transactions',
            'view_own_transactions',

            // Subscription permissions
            'manage_all_subscriptions',
            'view_all_subscriptions',
            'view_own_subscriptions',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $gymOwner = Role::firstOrCreate(['name' => 'gym_owner', 'guard_name' => 'web']);
        $member = Role::firstOrCreate(['name' => 'member', 'guard_name' => 'web']);

        // Assign permissions to roles
        $superAdmin->syncPermissions([
            'manage_all_gyms',
            'manage_all_plans',
            'manage_all_members',
            'manage_all_transactions',
            'manage_all_subscriptions',
            'view_all_members',
            'view_all_transactions',
            'view_all_subscriptions',
        ]);

        $gymOwner->syncPermissions([
            'manage_own_gym',
            'manage_own_plans',
            'view_all_members',
            'view_all_transactions',
            'view_all_subscriptions',
            'view_gym',
            'view_plan',
        ]);

        $member->syncPermissions([
            'view_own_profile',
            'view_own_transactions',
            'view_own_subscriptions',
            'view_gym',
            'view_plan',
        ]);
    }
}
