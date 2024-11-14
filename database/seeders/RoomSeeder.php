<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Room::create(['name' => 'Room 101', 'block' => 'A', 'short_name' => 'R101']);
        Room::create(['name' => 'Room 202', 'block' => 'B', 'short_name' => 'R202']);
    }
}
