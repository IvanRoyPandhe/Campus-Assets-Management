<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssetManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;
    protected $student;
    protected $location;

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

        // Create a test location
        $this->location = Location::create([
            'name' => 'Test Location',
            'building' => 'Test Building',
            'floor' => '1',
            'room' => '101',
        ]);
    }

    /** @test */
    public function admin_can_view_assets_page()
    {
        $response = $this->actingAs($this->admin)->get(route('assets.index'));
        $response->assertStatus(200);
        $response->assertViewIs('assets.index');
    }

    /** @test */
    public function student_can_view_assets_page()
    {
        $response = $this->actingAs($this->student)->get(route('assets.index'));
        $response->assertStatus(200);
        $response->assertViewIs('assets.index');
    }

    /** @test */
    public function admin_can_create_asset()
    {
        $response = $this->actingAs($this->admin)->get(route('assets.create'));
        $response->assertStatus(200);
        
        $assetData = [
            'name' => 'Test Asset',
            'category' => 'electronics',
            'location_id' => $this->location->id,
            'condition' => 'good',
            'purchase_date' => '2023-01-01',
            'description' => 'Test description',
        ];
        
        $response = $this->post(route('assets.store'), $assetData);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('assets', [
            'name' => 'Test Asset',
            'category' => 'electronics',
        ]);
    }

    /** @test */
    public function student_cannot_create_asset()
    {
        $response = $this->actingAs($this->student)->get(route('assets.create'));
        $response->assertStatus(403);
        
        $assetData = [
            'name' => 'Student Asset',
            'category' => 'electronics',
            'location_id' => $this->location->id,
            'condition' => 'good',
            'purchase_date' => '2023-01-01',
            'description' => 'Test description',
        ];
        
        $response = $this->post(route('assets.store'), $assetData);
        $response->assertStatus(403);
        
        $this->assertDatabaseMissing('assets', [
            'name' => 'Student Asset',
        ]);
    }

    /** @test */
    public function admin_can_update_asset()
    {
        $asset = Asset::create([
            'name' => 'Original Asset',
            'asset_code' => 'ASSET-' . rand(1000, 9999),
            'category' => 'electronics',
            'location_id' => $this->location->id,
            'condition' => 'good',
            'purchase_date' => '2023-01-01',
            'description' => 'Original description',
        ]);
        
        $response = $this->actingAs($this->admin)->get(route('assets.edit', $asset));
        $response->assertStatus(200);
        
        $updatedData = [
            'name' => 'Updated Asset',
            'category' => 'furniture',
            'location_id' => $this->location->id,
            'condition' => 'damaged',
            'purchase_date' => '2023-02-01',
            'description' => 'Updated description',
        ];
        
        $response = $this->put(route('assets.update', $asset), $updatedData);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'name' => 'Updated Asset',
            'category' => 'furniture',
            'condition' => 'damaged',
        ]);
    }

    /** @test */
    public function student_cannot_update_asset()
    {
        $asset = Asset::create([
            'name' => 'Student Test Asset',
            'asset_code' => 'ASSET-' . rand(1000, 9999),
            'category' => 'electronics',
            'location_id' => $this->location->id,
            'condition' => 'good',
            'purchase_date' => '2023-01-01',
            'description' => 'Test description',
        ]);
        
        $response = $this->actingAs($this->student)->get(route('assets.edit', $asset));
        $response->assertStatus(403);
        
        $updatedData = [
            'name' => 'Student Updated Asset',
            'category' => 'furniture',
            'location_id' => $this->location->id,
            'condition' => 'damaged',
            'purchase_date' => '2023-02-01',
            'description' => 'Updated description',
        ];
        
        $response = $this->put(route('assets.update', $asset), $updatedData);
        $response->assertStatus(403);
        
        $this->assertDatabaseMissing('assets', [
            'name' => 'Student Updated Asset',
        ]);
    }

    /** @test */
    public function admin_can_delete_asset()
    {
        $asset = Asset::create([
            'name' => 'Asset To Delete',
            'asset_code' => 'ASSET-' . rand(1000, 9999),
            'category' => 'electronics',
            'location_id' => $this->location->id,
            'condition' => 'good',
            'purchase_date' => '2023-01-01',
            'description' => 'Test description',
        ]);
        
        $response = $this->actingAs($this->admin)->delete(route('assets.destroy', $asset));
        $response->assertRedirect();
        
        $this->assertDatabaseMissing('assets', [
            'id' => $asset->id,
        ]);
    }

    /** @test */
    public function student_cannot_delete_asset()
    {
        $asset = Asset::create([
            'name' => 'Student Delete Asset',
            'asset_code' => 'ASSET-' . rand(1000, 9999),
            'category' => 'electronics',
            'location_id' => $this->location->id,
            'condition' => 'good',
            'purchase_date' => '2023-01-01',
            'description' => 'Test description',
        ]);
        
        $response = $this->actingAs($this->student)->delete(route('assets.destroy', $asset));
        $response->assertStatus(403);
        
        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
        ]);
    }

    /** @test */
    public function both_admin_and_student_can_view_asset_details()
    {
        $asset = Asset::create([
            'name' => 'View Asset',
            'asset_code' => 'ASSET-' . rand(1000, 9999),
            'category' => 'electronics',
            'location_id' => $this->location->id,
            'condition' => 'good',
            'purchase_date' => '2023-01-01',
            'description' => 'Test description',
        ]);
        
        // Admin can view
        $response = $this->actingAs($this->admin)->get(route('assets.show', $asset));
        $response->assertStatus(200);
        $response->assertViewIs('assets.show');
        $response->assertSee('View Asset');
        
        // Student can view
        $response = $this->actingAs($this->student)->get(route('assets.show', $asset));
        $response->assertStatus(200);
        $response->assertViewIs('assets.show');
        $response->assertSee('View Asset');
    }
}