<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_screen_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /** @test */
    public function new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
        
        // Check that the user was created with student role by default
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'role' => 'student',
        ]);
    }

    /** @test */
    public function users_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /** @test */
    public function admin_can_access_admin_routes()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('assets.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function student_cannot_access_admin_routes()
    {
        $student = User::factory()->create([
            'role' => 'student',
        ]);

        $response = $this->actingAs($student)->get(route('assets.create'));
        $response->assertStatus(403);
    }

    /** @test */
    public function guests_are_redirected_to_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get(route('assets.index'));
        $response->assertRedirect('/login');

        $response = $this->get(route('locations.index'));
        $response->assertRedirect('/login');
    }
}