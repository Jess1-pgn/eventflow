<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class DemoVenuesSeeder extends Seeder
{
    public function run(): void
    {
        $venues = [
            [
                'name' => 'Innovation Hub Downtown',
                'address_line1' => '123 Tech Street',
                'city' => 'San Francisco',
                'country' => 'US',
            ],
            [
                'name' => 'Grand Conference Center',
                'address_line1' => '456 Business Avenue',
                'city' => 'New York',
                'country' => 'US',
            ],
            [
                'name' => 'Creative Studios',
                'address_line1' => '789 Design Lane',
                'city' => 'Los Angeles',
                'country' => 'US',
            ],
            [
                'name' => 'Startup Incubator',
                'address_line1' => '321 Innovation Drive',
                'city' => 'Austin',
                'country' => 'US',
            ],
            [
                'name' => 'Virtual Event Platform',
                'address_line1' => 'Online',
                'city' => 'Worldwide',
                'country' => 'XX',
            ],
        ];

        foreach ($venues as $venue) {
            Venue::query()->firstOrCreate(
                ['name' => $venue['name']],
                $venue
            );
        }
    }
}
