<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CountrySeeder::class,
            VehicleClassificationSeeder::class,
            UserSeeder::class,
            SiteConfigSeeder::class,
            GroupSeeder::class,
            ERPSeeder::class,
            SystemTablesSeeder::class,
            CMSSeeder::class,
        ]);
    }
}
