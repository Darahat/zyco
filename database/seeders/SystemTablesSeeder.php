<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemTablesSeeder extends Seeder
{
    public function run(): void
    {
        // Currency
        DB::table('currency')->insertOrIgnore([
            ['currency_code' => 'EUR', 'currency_name' => 'Euro', 'currency_symbol' => '€', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['currency_code' => 'USD', 'currency_name' => 'US Dollar', 'currency_symbol' => '$', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['currency_code' => 'GBP', 'currency_name' => 'British Pound', 'currency_symbol' => '£', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Language
        DB::table('language')->insertOrIgnore([
            ['language_code' => 'en', 'language_name' => 'English', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['language_code' => 'nl', 'language_name' => 'Dutch', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['language_code' => 'de', 'language_name' => 'German', 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Fees
        DB::table('fees')->insertOrIgnore([
            ['fees_code' => 'BASE_FEE', 'fees_name' => 'Base Fee', 'amount' => 2.50, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['fees_code' => 'SERVICE_FEE', 'fees_name' => 'Service Fee', 'amount' => 1.50, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Timezones
        DB::table('timezones')->insertOrIgnore([
            ['timezone_name' => 'Europe/Amsterdam', 'timezone_offset' => '+01:00', 'created_at' => now(), 'updated_at' => now()],
            ['timezone_name' => 'Europe/London', 'timezone_offset' => '+00:00', 'created_at' => now(), 'updated_at' => now()],
            ['timezone_name' => 'America/New_York', 'timezone_offset' => '-05:00', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
