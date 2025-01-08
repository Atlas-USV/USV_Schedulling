<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Http; 

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //Faculty::create(['name' => 'Engineering', 'short_name' => 'ENG']);
        //Faculty::create(['name' => 'Sciences', 'short_name' => 'SCI']);
        //Faculty::create(['name' => 'Humanities', 'short_name' => 'HUM']);

         // URL-ul endpoint-ului
         $url = 'https://orar.usv.ro/orar/vizualizare/data/facultati.php?json';

         // Obține datele de la endpoint
         $response = Http::get($url);
 
         // Verifică dacă request-ul a fost cu succes
         if ($response->ok()) {
             $faculties = $response->json();
 
             // Iterează prin facultăți
             foreach ($faculties as $faculty) {
                 // Verifică dacă toate câmpurile necesare sunt completate
                 if (
                     !empty($faculty['id']) &&
                     !empty($faculty['shortName']) &&
                     !empty($faculty['longName'])
                 ) {
                     // Adaugă facultatea în baza de date
                     Faculty::updateOrCreate(
                         [
                             'id' => $faculty['id'], // Asigură-te că există un câmp `id` unic în baza de date
                         ],
                         [
                             'short_name' => $faculty['shortName'],
                             'name' => $faculty['longName'],
                         ]
                     );
                 }
             }
         } else {
             // Afișează eroare dacă request-ul eșuează
             $this->command->error('Nu s-a putut obține lista facultăților.');
         }
     
    }
}
