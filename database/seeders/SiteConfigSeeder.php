<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('site_config')->insert([
            'brand_name' => 'Zyco',
            'address' => 'Amsterdam, Netherlands',
            'invoice_email' => 'info@zyco.nl',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('login_config')->insert([
            [
                'login_type' => 'User',
                'welcome_text' => 'Welcome to Zyco - Your Trusted Taxi Service',
                'need_otp' => 'Disabled',
                'need_password' => 'Enabled',
                'need_email' => 'Enabled',
                'need_mobile' => 'Enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'login_type' => 'Admin',
                'welcome_text' => 'Zyco Admin Panel',
                'need_otp' => 'Disabled',
                'need_password' => 'Enabled',
                'need_email' => 'Enabled',
                'need_mobile' => 'Enabled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('account_classification_package')->insert([
            ['package_name' => 'Basic', 'description' => 'Basic driver package', 'price' => 0.00, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['package_name' => 'Professional', 'description' => 'Professional driver package', 'price' => 29.99, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['package_name' => 'Enterprise', 'description' => 'Enterprise fleet management', 'price' => 99.99, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
