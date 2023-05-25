<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 8 rooms with for 2 persons
        Room::factory()->count(8)->create(['occupancy' => 2]);

        // 3 rooms with for 3 persons
        Room::factory()->count(3)->create(['occupancy' => 3]);

        // 2 rooms with for 4 persons
        Room::factory()->count(2)->create(['occupancy' => 4]);
    }
}
