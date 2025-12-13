<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CMSSeeder extends Seeder
{
    public function run(): void
    {
        // Post Categories
        DB::table('postcategories')->insertOrIgnore([
            ['title' => 'News', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Announcements', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Menus
        DB::table('menus')->insertOrIgnore([
            ['menu_name' => 'Home', 'menu_type' => 'top', 'menu_order' => 1, 'parent_menu' => null, 'slug' => 'home', 'created_at' => now(), 'updated_at' => now()],
            ['menu_name' => 'About', 'menu_type' => 'top', 'menu_order' => 2, 'parent_menu' => null, 'slug' => 'about', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Pages
        DB::table('pages')->insertOrIgnore([
            ['title' => 'Terms & Conditions', 'content' => 'Terms and conditions content here.', 'slug' => 'terms', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Privacy Policy', 'content' => 'Privacy policy content here.', 'slug' => 'privacy', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Posts
        DB::table('posts')->insertOrIgnore([
            ['title' => 'Welcome to Zyco', 'content' => 'Welcome post content.', 'category' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
