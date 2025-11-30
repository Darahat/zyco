<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['country_name' => 'Netherlands', 'country_code' => 'NL', 'phone_code' => '+31', 'status' => 'Active'],
            ['country_name' => 'Belgium', 'country_code' => 'BE', 'phone_code' => '+32', 'status' => 'Active'],
            ['country_name' => 'Germany', 'country_code' => 'DE', 'phone_code' => '+49', 'status' => 'Active'],
            ['country_name' => 'France', 'country_code' => 'FR', 'phone_code' => '+33', 'status' => 'Active'],
            ['country_name' => 'United Kingdom', 'country_code' => 'GB', 'phone_code' => '+44', 'status' => 'Active'],
        ];

        foreach ($countries as $country) {
            DB::table('country')->insert(array_merge($country, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
