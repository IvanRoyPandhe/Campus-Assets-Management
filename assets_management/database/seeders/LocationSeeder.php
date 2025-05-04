<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Main Building - Room 101',
                'building' => 'Main Building',
                'floor' => '1',
                'room' => '101',
                'description' => 'Computer Laboratory'
            ],
            [
                'name' => 'Main Building - Room 102',
                'building' => 'Main Building',
                'floor' => '1',
                'room' => '102',
                'description' => 'Physics Laboratory'
            ],
            [
                'name' => 'Library - First Floor',
                'building' => 'Library',
                'floor' => '1',
                'room' => 'Main Hall',
                'description' => 'Main Reading Area'
            ],
            [
                'name' => 'Administration Building - Office 201',
                'building' => 'Administration Building',
                'floor' => '2',
                'room' => '201',
                'description' => 'Dean\'s Office'
            ],
            [
                'name' => 'Student Center',
                'building' => 'Student Center',
                'floor' => 'Ground',
                'room' => 'Main Hall',
                'description' => 'Student Activities Area'
            ],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}