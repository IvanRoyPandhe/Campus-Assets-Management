<?php

namespace Tests\Unit;

use App\Models\Asset;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function asset_has_auto_generated_asset_code()
    {
        $location = Location::factory()->create();
        
        $asset = Asset::create([
            'name' => 'Test Asset',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'good',
        ]);
        
        $this->assertNotNull($asset->asset_code);
        $this->assertStringStartsWith('ASSET-', $asset->asset_code);
    }

    /** @test */
    public function asset_belongs_to_location()
    {
        $location = Location::factory()->create();
        
        $asset = Asset::create([
            'name' => 'Test Asset',
            'asset_code' => 'ASSET-1234',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'good',
        ]);
        
        $this->assertInstanceOf(Location::class, $asset->location);
        $this->assertEquals($location->id, $asset->location->id);
    }

    /** @test */
    public function asset_has_correct_condition_options()
    {
        $location = Location::factory()->create();
        
        $goodAsset = Asset::create([
            'name' => 'Good Asset',
            'asset_code' => 'ASSET-1001',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'good',
        ]);
        
        $damagedAsset = Asset::create([
            'name' => 'Damaged Asset',
            'asset_code' => 'ASSET-1002',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'damaged',
        ]);
        
        $repairAsset = Asset::create([
            'name' => 'Repair Asset',
            'asset_code' => 'ASSET-1003',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'under repair',
        ]);
        
        $this->assertEquals('good', $goodAsset->condition);
        $this->assertEquals('damaged', $damagedAsset->condition);
        $this->assertEquals('under repair', $repairAsset->condition);
    }

    /** @test */
    public function asset_has_correct_category_options()
    {
        $location = Location::factory()->create();
        
        $categories = [
            'furniture',
            'electronics',
            'office equipment',
            'laboratory equipment',
            'sports equipment',
            'other'
        ];
        
        foreach ($categories as $index => $category) {
            $asset = Asset::create([
                'name' => "Asset $index",
                'asset_code' => "ASSET-$index",
                'category' => $category,
                'location_id' => $location->id,
                'condition' => 'good',
            ]);
            
            $this->assertEquals($category, $asset->category);
        }
    }

    /** @test */
    public function asset_purchase_date_is_nullable()
    {
        $location = Location::factory()->create();
        
        $assetWithDate = Asset::create([
            'name' => 'Asset With Date',
            'asset_code' => 'ASSET-DATE',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'good',
            'purchase_date' => '2023-01-01',
        ]);
        
        $assetWithoutDate = Asset::create([
            'name' => 'Asset Without Date',
            'asset_code' => 'ASSET-NODATE',
            'category' => 'electronics',
            'location_id' => $location->id,
            'condition' => 'good',
            'purchase_date' => null,
        ]);
        
        $this->assertNotNull($assetWithDate->purchase_date);
        $this->assertNull($assetWithoutDate->purchase_date);
    }
}