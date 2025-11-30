<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoutingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function root_route_redirects_to_login()
    {
        $response = $this->get('/');
        
        $response->assertRedirect('/login');
    }

    /** @test */
    public function login_config_exists_in_database()
    {
        $this->seed(\Database\Seeders\SiteConfigSeeder::class);

        $this->assertDatabaseHas('login_config', [
            'login_type' => 'User',
        ]);

        $this->assertDatabaseHas('login_config', [
            'login_type' => 'Admin',
        ]);
    }

    /** @test */
    public function admin_seeder_creates_default_admin()
    {
        $this->seed(\Database\Seeders\AdminSeeder::class);

        $this->assertDatabaseHas('admins', [
            'email' => 'admin@zyco.nl',
        ]);
    }

    /** @test */
    public function country_seeder_creates_countries()
    {
        $this->seed(\Database\Seeders\CountrySeeder::class);

        $this->assertDatabaseHas('country', [
            'country_name' => 'Netherlands',
        ]);
    }
}
