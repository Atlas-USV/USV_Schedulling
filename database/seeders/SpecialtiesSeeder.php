<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Speciality;
use App\Models\Faculty;

class SpecialtiesSeeder extends Seeder
{
    public function run()
    {
        // Endpoint-ul pentru datele despre specializări
        $endpoint = 'https://orar.usv.ro/orar/vizualizare/data/subgrupe.php?json';

        // Fetch JSON data
        $response = Http::get($endpoint);

        // Verificăm răspunsul
        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $item) {
                // Verificăm dacă există facultyId și specializationShortName
                if (!empty($item['facultyId']) && !empty($item['specializationShortName'])) {
                    // Căutăm facultatea în baza de date după ID
                    $faculty = Faculty::find($item['facultyId']);

                    if ($faculty) {
                        // Creăm sau actualizăm specialitatea
                        Speciality::updateOrCreate(
                            [
                                'short_name' => $item['specializationShortName'],
                                'faculty_id' => $faculty->id,
                            ],
                            [
                                'name' => $item['specializationShortName'],
                            ]
                        );
                    } else {
                        $this->command->warn("Faculty not found: {$item['facultyId']}");
                    }
                }
            }

            $this->command->info('Specialities have been seeded successfully.');
        } else {
            $this->command->error('Failed to fetch data from the endpoint.');
        }
    }
}
