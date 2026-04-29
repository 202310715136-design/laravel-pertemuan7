<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'api_token' => Str::random(60),
        ]);

        $customer = User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'role' => 'customer',
            'api_token' => Str::random(60),
        ]);

        Transaksi::factory()
            ->for($customer)
            ->count(2)
            ->create();

        // Example credentials:
        // Admin: admin@example.com / password
        // Customer: customer@example.com / password
    }
}
