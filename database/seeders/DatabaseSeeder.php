<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\PlayerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Superadmin User
        User::updateOrCreate(
            ['email' => 'superadmin@ssb.com'],
            [
                'name' => 'Superadmin SSB',
                'role' => 'superadmin',
                'password' => Hash::make('123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Regular Player User
        $user = User::updateOrCreate(
            ['email' => 'user@ssb.com'],
            [
                'name' => 'Player SSB',
                'role' => 'user',
                'password' => Hash::make('123'),
                'email_verified_at' => now(),
            ]
        );

        // 3. Create Player Profile for Regular User
        PlayerProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'full_name' => 'Player SSB',
                'gender' => 'L',
                'age' => 17,
                'height' => 172.50,
                'weight' => 64.00,
            ]
        );

        // 4. Run PositionIndicatorTestSeeder
        $this->call(PositionIndicatorTestSeeder::class);
    }
}
