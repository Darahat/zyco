<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users for different user types
        $users = [
            // Driver user
            [
                'name' => 'John Driver',
                'username' => 'johndriver',
                'first_name' => 'John',
                'last_name' => 'Driver',
                'email' => 'driver@test.com',
                'alt_email' => 'john.driver@personal.com',
                'mobile_number' => '+31612345678',
                'country_code' => '+31',
                'can_speak' => 'English,Dutch',
                'base_city' => 'Amsterdam',
                'time_zone' => 'Europe/Amsterdam',
                'language' => 'en',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'user_type' => 'Driver',
                'need_otp' => 'Enabled',
            ],
            // Rider user
            [
                'name' => 'Jane Rider',
                'username' => 'janerider',
                'first_name' => 'Jane',
                'last_name' => 'Rider',
                'email' => 'rider@test.com',
                'alt_email' => null,
                'mobile_number' => '+31687654321',
                'country_code' => '+31',
                'can_speak' => 'English',
                'base_city' => 'Rotterdam',
                'time_zone' => 'Europe/Amsterdam',
                'language' => 'en',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'user_type' => 'Rider',
                'need_otp' => 'Disabled',
            ],
            // Dispatcher user
            [
                'name' => 'Mike Dispatcher',
                'username' => 'mikedispatcher',
                'first_name' => 'Mike',
                'last_name' => 'Dispatcher',
                'email' => 'dispatcher@test.com',
                'alt_email' => null,
                'mobile_number' => '+31698765432',
                'country_code' => '+31',
                'can_speak' => 'Dutch,German',
                'base_city' => 'Utrecht',
                'time_zone' => 'Europe/Amsterdam',
                'language' => 'nl',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'user_type' => 'Dispatcher',
                'need_otp' => 'Enabled',
            ],
            // Additional test user
            [
                'name' => 'Test User',
                'username' => 'testuser',
                'first_name' => 'Test',
                'last_name' => 'User',
                'email' => 'test@test.com',
                'alt_email' => null,
                'mobile_number' => '+31612345679',
                'country_code' => '+31',
                'can_speak' => 'English',
                'base_city' => 'Amsterdam',
                'time_zone' => 'Europe/Amsterdam',
                'language' => 'en',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'user_type' => 'Driver',
                'need_otp' => 'Disabled',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}