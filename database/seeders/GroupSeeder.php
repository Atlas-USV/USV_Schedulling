<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Group;
use App\Models\Speciality;

class GroupSeeder extends Seeder
{
    public function run()
    {
        $endpoint = 'https://orar.usv.ro/orar/vizualizare/data/subgrupe.php?json';
        $response = Http::get($endpoint);

        
        $nextNumber = 1;

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $item) {
                
                $speciality = Speciality::where('short_name', $item['specializationShortName'])->first();

                if ($speciality) {

                    $number = is_numeric($item['groupName']) ? intval($item['groupName']) : $nextNumber++;

                    Group::updateOrCreate(
                        [
                            'name' => $item['groupName'], 
                            'speciality_id' => $speciality->id,
                        ],
                        [
                            'number' => $number, 
                            'study_year' => $item['studyYear'],
                        ]
                    );
                } else {
                    $this->command->warn("Missing speciality for: " . $item['groupName']);
                }
            }

            $this->command->info('Groups have been seeded successfully.');
        } else {
            $this->command->error('Failed to fetch data from the endpoint.');
        }
    }
}
