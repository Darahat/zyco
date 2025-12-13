<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ERPSeeder extends Seeder
{
    public function run(): void
    {
        // Districts
        DB::table('districts')->insertOrIgnore([
            ['name' => 'Dhaka', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Chittagong', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // HSC Subject Groups
        DB::table('hsc_subject_group')->insertOrIgnore([
            ['class_name' => 'HSC', 'group_name' => 'Science', 'subject_name' => 'Physics', 'created_at' => now(), 'updated_at' => now()],
            ['class_name' => 'HSC', 'group_name' => 'Commerce', 'subject_name' => 'Accounting', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Class Subjects
        DB::table('class_subject')->insertOrIgnore([
            ['class_name' => 'Class 10', 'GROUP_ID' => 1, 'subject_name' => 'Mathematics', 'created_at' => now(), 'updated_at' => now()],
            ['class_name' => 'Class 10', 'GROUP_ID' => 1, 'subject_name' => 'English', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Students
        DB::table('students')->insertOrIgnore([
            ['S_REGNO' => 'REG001', 'name' => 'Alice', 'CLASS_ROLL' => 1, 'GROUP_ID' => 1, 'is_exist' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['S_REGNO' => 'REG002', 'name' => 'Bob', 'CLASS_ROLL' => 2, 'GROUP_ID' => 1, 'is_exist' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
