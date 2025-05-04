<?php

namespace Tests\Unit;

use App\Models\Asset;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function location_can_have_many_assets()
    {
        $location = Location::create([
            'name' => 'Test Location',
            'building' => 'Test Building',
            'floor' => '1',
            'room' => '101',
        ]);
        
        Asset::create([
            'name' => 'Asset 1',
            'asset_code' => 'ASSET-1001',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'good',
        ]);
        
        Asset::create([
            'name' => 'Asset 2',
            'asset_code' => 'ASSET-1002',
            'category' => 'furniture',
            'location_id' => $location->id,
            'condition' => 'good',
        ]);
        
        $this->assertCount(2, $location->assets);
    }

    /** @test */
    public function location_building_floor_and_room_are_nullable()
    {
        $location = Location::create([
            'name' => 'Minimal Location',
        ]);
        
        $this->assertNull($location->building);
        $this->assertNull($location->floor);
        $this->assertNull($location->room);
        
        $this->assertDatabaseHas('locations', [
            'name' => 'Minimal Location',
            'building' => null,
            'floor' => null,
            'room' => null,
        ]);
    }

    /** @test */
    public function location_name_is_required()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        $location = Location::create([
            'building' => 'Test Building',
            'floor' => '1',
            'room' => '101',
        ]);
    }

    /** @test */
    public function deleting_location_does_not_delete_associated_assets()
    {
        $location = Location::create([
            'name' => 'Delete Test Location',
            'building' => 'Test Building',
            'floor' => '1',
            'room' => '101',
        ]);
        
        $asset = Asset::create([
            'name' => 'Orphan Asset',
            'asset_code' => 'ASSET-ORPHAN',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'good',
        ]);
        
        // This would normally fail in the application due to the constraint check,
        // but for testing the model behavior directly, we'll force delete
        $location->delete();
        
        // Asset should still exist in database
        $this->assertDatabaseHas('assets', [
            'name' => 'Orphan Asset',
            'asset_code' => 'ASSET-ORPHAN',
        ]);
    }
}