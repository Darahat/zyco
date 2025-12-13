<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        // Create a sample group if none exist
        $groupId = DB::table('users_group')->insertGetId([
            'group_name' => 'Default Group',
            'owner_id' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add owner as a member
        DB::table('users_group_members')->insert([
            'group_id' => $groupId,
            'member_id' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
