<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LocationManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $student;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create student user
        $this->student = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'role' => 'student',
        ]);
    }

    /** @test */
    public function admin_can_view_locations_page()
    {
        $response = $this->actingAs($this->admin)->get(route('locations.index'));
        $response->assertStatus(200);
        $response->assertViewIs('locations.index');
    }

    /** @test */
    public function student_can_view_locations_page()
    {
        $response = $this->actingAs($this->student)->get(route('locations.index'));
        $response->assertStatus(200);
        $response->assertViewIs('locations.index');
    }

    /** @test */
    public function admin_can_create_location()
    {
        $response = $this->actingAs($this->admin)->get(route('locations.create'));
        $response->assertStatus(200);
        
        $locationData = [
            'name' => 'New Test Location',
            'building' => 'Test Building',
            'floor' => '2',
            'room' => '202',
            'description' => 'Test location description',
        ];
        
        $response = $this->post(route('locations.store'), $locationData);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('locations', [
            'name' => 'New Test Location',
            'building' => 'Test Building',
        ]);
    }

    /** @test */
    public function student_cannot_create_location()
    {
        $response = $this->actingAs($this->student)->get(route('locations.create'));
        $response->assertStatus(403);
        
        $locationData = [
            'name' => 'Student Location',
            'building' => 'Student Building',
            'floor' => '3',
            'room' => '303',
            'description' => 'Student location description',
        ];
        
        $response = $this->post(route('locations.store'), $locationData);
        $response->assertStatus(403);
        
        $this->assertDatabaseMissing('locations', [
            'name' => 'Student Location',
        ]);
    }

    /** @test */
    public function admin_can_update_location()
    {
        $location = Location::create([
            'name' => 'Original Location',
            'building' => 'Original Building',
            'floor' => '1',
            'room' => '101',
            'description' => 'Original description',
        ]);
        
        $response = $this->actingAs($this->admin)->get(route('locations.edit', $location));
        $response->assertStatus(200);
        
        $updatedData = [
            'name' => 'Updated Location',
            'building' => 'Updated Building',
            'floor' => '2',
            'room' => '202',
            'description' => 'Updated description',
        ];
        
        $response = $this->put(route('locations.update', $location), $updatedData);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
            'name' => 'Updated Location',
            'building' => 'Updated Building',
        ]);
    }

    /** @test */
    public function student_cannot_update_location()
    {
        $location = Location::create([
            'name' => 'Student Test Location',
            'building' => 'Student Test Building',
            'floor' => '1',
            'room' => '101',
            'description' => 'Test description',
        ]);
        
        $response = $this->actingAs($this->student)->get(route('locations.edit', $location));
        $response->assertStatus(403);
        
        $updatedData = [
            'name' => 'Student Updated Location',
            'building' => 'Student Updated Building',
            'floor' => '2',
            'room' => '202',
            'description' => 'Updated description',
        ];
        
        $response = $this->put(route('locations.update', $location), $updatedData);
        $response->assertStatus(403);
        
        $this->assertDatabaseMissing('locations', [
            'name' => 'Student Updated Location',
        ]);
    }

    /** @test */
    public function admin_can_delete_location_without_assets()
    {
        $location = Location::create([
            'name' => 'Location To Delete',
            'building' => 'Delete Building',
            'floor' => '1',
            'room' => '101',
            'description' => 'Test description',
        ]);
        
        $response = $this->actingAs($this->admin)->delete(route('locations.destroy', $location));
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('locations', [
            'id' => $location->id,
        ]);
    }

    /** @test */
    public function admin_cannot_delete_location_with_assets()
    {
        $location = Location::create([
            'name' => 'Location With Assets',
            'building' => 'Asset Building',
            'floor' => '1',
            'room' => '101',
            'description' => 'Test description',
        ]);
        
        // Create an asset associated with this location
        Asset::create([
            'name' => 'Associated Asset',
            'asset_code' => 'ASSET-' . rand(1000, 9999),
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'good',
            'purchase_date' => '2023-01-01',
            'description' => 'Test description',
        ]);
        
        $response = $this->actingAs($this->admin)->delete(route('locations.destroy', $location));
        $response->assertRedirect();
        
        // Location should still exist
        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
        ]);
    }

    /** @test */
    public function student_cannot_delete_location()
    {
        $location = Location::create([
            'name' => 'Student Delete Location',
            'building' => 'Student Delete Building',
            'floor' => '1',
            'room' => '101',
            'description' => 'Test description',
        ]);
        
        $response = $this->actingAs($this->student)->delete(route('locations.destroy', $location));
        $response->assertStatus(403);
        
        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
        ]);
    }

    /** @test */
    public function both_admin_and_student_can_view_location_details()
    {
        $location = Location::create([
            'name' => 'View Location',
            'building' => 'View Building',
            'floor' => '1',
            'room' => '101',
            'description' => 'Test description',
        ]);
        
        // Admin can view
        $response = $this->actingAs($this->admin)->get(route('locations.show', $location));
        $response->assertStatus(200);
        $response->assertViewIs('locations.show');
        $response->assertSee('View Location');
        
        // Student can view
        $response = $this->actingAs($this->student)->get(route('locations.show', $location));
        $response->assertStatus(200);
        $response->assertViewIs('locations.show');
        $response->assertSee('View Location');
    }
}