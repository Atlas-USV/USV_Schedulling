<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProfessorSeeder extends Seeder
{
    public function run()
    {

        $url = "https://orar.usv.ro/orar/vizualizare/data/cadre.php?json";

        // Obține datele de la endpoint
        $response = Http::withOptions(['verify' => false])->get($url);


        if ($response->successful()) {
            $professors = $response->json();

            foreach ($professors as $professor) {
                // Verificăm dacă avem `facultyName` complet
                if (!isset($professor['facultyName'], $professor['emailAddress'])) {
                    continue;
                }

                // Găsim facultatea pe baza `facultyName`
                $faculty = Faculty::where('name', $professor['facultyName'])->first();

                if (!$faculty) {
                    // Dacă facultatea nu există, trecem peste acest profesor
                    continue;
                }

                // Creăm sau actualizăm profesorul în tabelul users
                $user = User::updateOrCreate( // Atribuim rezultatul metodei unei variabile
                    [
                        'email' => $professor['emailAddress'],
                    ],
                    [
                        'name' => $professor['firstName'] . ' ' . $professor['lastName'], // Concatenăm numele
                        'password' => bcrypt('TemporaryPassword123'),
                        'teacher_faculty_id' => $faculty->id, // Atribuim facultatea
                    ]
                );

                // Atribuim rolul de 'teacher'
                if ($user && !$user->hasRole('teacher')) {
                    $user->assignRole('teacher');
                }
            }
        } else {
            // Dacă cererea eșuează, afișăm un mesaj de eroare
            $this->command->error('Failed to fetch data from the endpoint.');
        }
    }
}
