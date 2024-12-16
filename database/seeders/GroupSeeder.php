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

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $item) {
                // Verificăm dacă specialitatea există
                $speciality = Speciality::where('short_name', $item['specializationShortName'])->first();

                if ($speciality && is_numeric($item['groupName'])) { // Verificăm dacă groupName este numeric
                    Group::updateOrCreate(
                        [
                            'name' => $item['groupName'],
                            'speciality_id' => $speciality->id,
                        ],
                        [
                            'number' => intval($item['groupName']), // Salvăm doar numere întregi
                            'study_year' => $item['studyYear'],
                        ]
                    );
                } else {
                    $this->command->warn("Invalid group data or missing speciality for: " . $item['groupName']);
                }
            }

            $this->command->info('Groups have been seeded successfully.');
        } else {
            $this->command->error('Failed to fetch data from the endpoint.');
        }
    }
}
