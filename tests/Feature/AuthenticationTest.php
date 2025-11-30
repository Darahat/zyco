<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_page_loads_successfully()
    {
        // Seed required config data
        $this->seed(\Database\Seeders\SiteConfigSeeder::class);
        
        $response = $this->get('/login');
        
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function user_can_login_with_email()
    {
        $user = User::create([
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'mobile_number' => '1234567890',
            'password' => Hash::make('password123'),
            'user_type' => 'Driver',
        ]);

        $response = $this->post('/user-custom-login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Controller returns mobile number on success
        $response->assertStatus(200);
        $this->assertEquals('1234567890', $response->getContent());
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_can_login_with_mobile_number()
    {
        $user = User::create([
            'name' => 'Test User Mobile',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'mobile_number' => '1234567890',
            'password' => Hash::make('password123'),
            'user_type' => 'Driver',
        ]);

        $response = $this->post('/user-custom-login', [
            'email' => '1234567890', // Using mobile as email field
            'password' => 'password123',
        ]);

        // Controller returns mobile number on success
        $response->assertStatus(200);
        $this->assertEquals('1234567890', $response->getContent());
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        User::create([
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'mobile_number' => '1234567890',
            'password' => Hash::make('password123'),
            'user_type' => 'Driver',
        ]);

        $response = $this->post('/user-custom-login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        // Controller returns null on failure
        $response->assertStatus(200);
        $this->assertEmpty($response->getContent());
        $this->assertGuest();
    }

    /** @test */
    public function user_registration_page_loads()
    {
        $response = $this->get('/user-user_registration');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_register_successfully()
    {
        $response = $this->post('/user-custom-registration', [
            'first_name' => 'New',
            'last_name' => 'User',
            'email' => 'newuser@example.com',
            'mobile_number' => '9876543210',
            'password' => 'password123',
            'user_type' => 'Driver',
            'base_city' => 'Amsterdam',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'mobile_number' => '9876543210',
            'user_type' => 'Driver',
        ]);
    }

    /** @test */
    public function email_must_be_unique_during_registration()
    {
        User::create([
            'name' => 'Existing User',
            'first_name' => 'Existing',
            'last_name' => 'User',
            'email' => 'existing@example.com',
            'mobile_number' => '1234567890',
            'password' => Hash::make('password123'),
            'user_type' => 'Driver',
        ]);

        $response = $this->post('/user-custom-registration', [
            'first_name' => 'New',
            'last_name' => 'User',
            'email' => 'existing@example.com',
            'mobile_number' => '9876543210',
            'password' => 'password123',
            'user_type' => 'Driver',
            'base_city' => 'Amsterdam',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function mobile_number_must_be_unique_during_registration()
    {
        User::create([
            'name' => 'Existing User Mobile',
            'first_name' => 'Existing',
            'last_name' => 'User',
            'email' => 'existing@example.com',
            'mobile_number' => '1234567890',
            'password' => Hash::make('password123'),
            'user_type' => 'Driver',
        ]);

        $response = $this->post('/user-custom-registration', [
            'first_name' => 'New',
            'last_name' => 'User',
            'email' => 'newuser@example.com',
            'mobile_number' => '1234567890',
            'password' => 'password123',
            'user_type' => 'Driver',
            'base_city' => 'Amsterdam',
        ]);

        $response->assertSessionHasErrors('mobile_number');
    }

    /** @test */
    public function rider_can_login()
    {
        $user = User::create([
            'name' => 'Rider User',
            'first_name' => 'Rider',
            'last_name' => 'User',
            'email' => 'rider@example.com',
            'mobile_number' => '1111111111',
            'password' => Hash::make('password123'),
            'user_type' => 'Rider',
        ]);

        $response = $this->post('/user-custom-login', [
            'email' => 'rider@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $this->assertEquals('1111111111', $response->getContent());
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function dispatcher_can_login()
    {
        $user = User::create([
            'name' => 'Dispatcher User',
            'first_name' => 'Dispatcher',
            'last_name' => 'User',
            'email' => 'dispatcher@example.com',
            'mobile_number' => '2222222222',
            'password' => Hash::make('password123'),
            'user_type' => 'Dispatcher',
        ]);

        $response = $this->post('/user-custom-login', [
            'email' => 'dispatcher@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $this->assertEquals('2222222222', $response->getContent());
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::create([
            'name' => 'Test User Logout',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'mobile_number' => '1234567890',
            'password' => Hash::make('password123'),
            'user_type' => 'Driver',
        ]);

        $this->actingAs($user);

        $response = $this->get('/signout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}