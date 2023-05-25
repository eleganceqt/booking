<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Guest;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guest::factory()->create();

        Room::factory()->create(['occupancy' => 2]);
    }
}
