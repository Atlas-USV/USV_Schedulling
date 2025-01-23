<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            // Replace this URL with your actual API endpoint
            $url = 'https://orar.usv.ro/orar/vizualizare/data/sali.php?json';
            $response = Http::withOptions(['verify' => false])->get($url);

            if ($response->successful()) {
                $rooms = $response->json();
                // \Log::info('Parsed rooms:', $rooms);
                foreach ($rooms as $roomData) {
                    if (!is_null($roomData['name']) && !is_null($roomData['buildingName']) && !is_null($roomData['shortName'])) {
                        Room::create([
                            'name' => $roomData['name'],
                            'block' => $roomData['buildingName'],
                            'short_name' => $roomData['shortName'],
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            // Fallback data in case API is not available
            // $defaultRooms = [
            //     ['name' => 'C001', 'block' => 'C', 'short_name' => 'C001'],
            //     ['name' => 'C002', 'block' => 'C', 'short_name' => 'C002'],
            //     ['name' => 'A101', 'block' => 'A', 'short_name' => 'A101'],
            //     ['name' => 'B201', 'block' => 'B', 'short_name' => 'B201'],
            // ];

            // foreach ($defaultRooms as $room) {
            //     Room::create($room);
            // }
        }
    }
}
