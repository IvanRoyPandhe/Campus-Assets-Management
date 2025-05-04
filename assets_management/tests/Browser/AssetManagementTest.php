<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AssetManagementTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test admin can create a new asset.
     */
    public function testAdminCanCreateAsset(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $location = Location::create([
            'name' => 'Test Location',
            'building' => 'Test Building',
            'floor' => '1',
            'room' => '101',
        ]);

        $this->browse(function (Browser $browser) use ($location) {
            $browser->visit('/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->assertPathIs('/dashboard')
                    ->visit('/assets/create')
                    ->type('name', 'New Test Asset')
                    ->select('category', 'electronics')
                    ->select('location_id', $location->id)
                    ->select('condition', 'good')
                    ->type('purchase_date', '2023-01-01')
                    ->type('description', 'This is a test asset')
                    ->press('Create Asset')
                    ->assertPathIs('/assets/' . $location->id)
                    ->assertSee('Asset created successfully')
                    ->assertSee('New Test Asset');
        });
    }

    /**
     * Test admin can edit an asset.
     */
    public function testAdminCanEditAsset(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $location = Location::create([
            'name' => 'Test Location',
            'building' => 'Test Building',
            'floor' => '1',
            'room' => '101',
        ]);

        $asset = \App\Models\Asset::create([
            'name' => 'Asset To Edit',
            'asset_code' => 'ASSET-EDIT',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'good',
            'purchase_date' => '2023-01-01',
            'description' => 'Original description',
        ]);

        $this->browse(function (Browser $browser) use ($asset) {
            $browser->visit('/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->visit('/assets/' . $asset->id . '/edit')
                    ->type('name', 'Updated Asset Name')
                    ->select('condition', 'damaged')
                    ->type('description', 'Updated description')
                    ->press('Update Asset')
                    ->assertPathIs('/assets/' . $asset->id)
                    ->assertSee('Asset updated successfully')
                    ->assertSee('Updated Asset Name')
                    ->assertSee('Damaged');
        });
    }

    /**
     * Test student cannot access asset creation page.
     */
    public function testStudentCannotCreateAsset(): void
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
                    ->visit('/assets/create')
                    ->assertSee('403')
                    ->assertSee('Unauthorized');
        });
    }

    /**
     * Test theme toggle functionality.
     */
    public function testThemeToggle(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'user@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->assertAttribute('html', 'data-bs-theme', 'light')
                    ->click('#themeToggle')
                    ->pause(500)
                    ->assertAttribute('html', 'data-bs-theme', 'dark')
                    ->click('#themeToggle')
                    ->pause(500)
                    ->assertAttribute('html', 'data-bs-theme', 'light');
        });
    }

    /**
     * Test asset search functionality.
     */
    public function testAssetSearch(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $location = Location::create([
            'name' => 'Test Location',
        ]);

        // Create test assets
        \App\Models\Asset::create([
            'name' => 'Laptop Dell XPS',
            'asset_code' => 'ASSET-DELL',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'good',
        ]);

        \App\Models\Asset::create([
            'name' => 'Office Chair',
            'asset_code' => 'ASSET-CHAIR',
            'category' => 'furniture',
            'location_id' => $location->id,
            'condition' => 'good',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'admin@example.com')
                    ->type('password', 'password')
                    ->press('Log in')
                    ->visit('/assets')
                    ->assertSee('Laptop Dell XPS')
                    ->assertSee('Office Chair')
                    ->type('#assetSearch', 'laptop')
                    ->pause(500)
                    ->assertSee('Laptop Dell XPS')
                    ->assertDontSee('Office Chair')
                    ->clear('#assetSearch')
                    ->type('#assetSearch', 'chair')
                    ->pause(500)
                    ->assertDontSee('Laptop Dell XPS')
                    ->assertSee('Office Chair');
        });
    }
}