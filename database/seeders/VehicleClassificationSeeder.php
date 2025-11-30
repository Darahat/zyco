<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classifications = [
            ['classification_name' => 'Sedan', 'description' => 'Standard sedan vehicles', 'status' => 'Active'],
            ['classification_name' => 'SUV', 'description' => 'Sport Utility Vehicles', 'status' => 'Active'],
            ['classification_name' => 'Van', 'description' => 'Passenger and cargo vans', 'status' => 'Active'],
            ['classification_name' => 'Luxury', 'description' => 'Premium luxury vehicles', 'status' => 'Active'],
            ['classification_name' => 'Electric', 'description' => 'Electric vehicles', 'status' => 'Active'],
        ];

        foreach ($classifications as $classification) {
            DB::table('vehicle_classification')->insert(array_merge($classification, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Add some vehicle makes
        $makes = [
            ['make_vehicle_name' => 'Toyota', 'status' => 'Active'],
            ['make_vehicle_name' => 'Mercedes-Benz', 'status' => 'Active'],
            ['make_vehicle_name' => 'BMW', 'status' => 'Active'],
            ['make_vehicle_name' => 'Volkswagen', 'status' => 'Active'],
            ['make_vehicle_name' => 'Tesla', 'status' => 'Active'],
        ];

        foreach ($makes as $make) {
            DB::table('vehicle_make')->insert(array_merge($make, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
