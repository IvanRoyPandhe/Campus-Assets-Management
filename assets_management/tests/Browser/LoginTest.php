<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test successful login.
     */
    public function testSuccessfulLogin(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'test@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->assertPathIs('/dashboard');
        });
    }

    /**
     * Test failed login with incorrect credentials.
     */
    public function testFailedLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'wrong@example.com')
                    ->type('password', 'wrong-password')
                    ->press('Log in')
                    ->assertSee('These credentials do not match our records');
        });
    }

    /**
     * Test admin login and access to admin features.
     */
    public function testAdminLogin(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Admin')
                    ->visit('/assets')
                    ->assertSee('Add New Asset');
        });
    }

    /**
     * Test student login and restricted access.
     */
    public function testStudentLogin(): void
    {
        $student = User::factory()->create([
            'email' => 'student@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'student@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Student')
                    ->visit('/assets')
                    ->assertDontSee('Add New Asset');
        });
    }

    /**
     * Test logout functionality.
     */
    public function testLogout(): void
    {
        $user = User::factory()->create([
            'email' => 'logout@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'logout@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->assertPathIs('/dashboard')
                    ->click('#navbarDropdown')
                    ->waitFor('.dropdown-menu')
                    ->clickLink('Log Out')
                    ->assertPathIs('/');
        });
    }
}