<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_login_page_loads_successfully()
    {
        // Seed required config data
        $this->seed(\Database\Seeders\SiteConfigSeeder::class);
        
        $response = $this->get('/admin-login');
        
        $response->assertStatus(200);
        $response->assertViewIs('auth.admin_login');
    }

    /** @test */
    public function admin_can_login_with_valid_credentials()
    {
        $admin = Admin::create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@zyco.nl',
            'mobile_number' => '1234567890',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/authenticate', [
            'email' => 'admin@zyco.nl',
            'password' => 'password',
        ]);

        // Controller returns mobile number on success
        $response->assertStatus(200);
        $this->assertEquals('1234567890', $response->getContent());
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    /** @test */
    public function admin_cannot_login_with_invalid_credentials()
    {
        Admin::create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@zyco.nl',
            'mobile_number' => '1234567890',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/authenticate', [
            'email' => 'admin@zyco.nl',
            'password' => 'wrongpassword',
        ]);

        // Controller returns null on failure
        $response->assertStatus(200);
        $this->assertEmpty($response->getContent());
        $this->assertGuest('admin');
    }

    /** @test */
    public function admin_can_access_dashboard_when_authenticated()
    {
        // Seed required data
        $this->seed(\Database\Seeders\CountrySeeder::class);
        $this->seed(\Database\Seeders\SiteConfigSeeder::class);
        
        $admin = Admin::create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@zyco.nl',
            'mobile_number' => '1234567890',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($admin, 'admin')->get('/admin-my-profile');

        $response->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_access_admin_routes()
    {
        $response = $this->get('/admin-my-profile');

        $response->assertRedirect('/admin-login');
    }
}
