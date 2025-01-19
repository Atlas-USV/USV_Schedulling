<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SubjectsSeeder extends Seeder
{
    // /**
    //  * Rulează seeder-ul.
    //  */
    // public function run()
    // {
    //     // Citește fișierul JSON
    //     $json = Storage::get('subgroup_details.json');
    //     $data = json_decode($json, true);
    //     $uniqueTopics = []; // Array pentru subiecte unice

    //     if (is_array($data)) {
    //         foreach ($data as $item) {
    //             if (isset($item['details'][1])) {
    //                 $groups = $item['details'][1];
    //                 foreach ($groups as $groupId => $groupData) {
    //                     if (strpos($groupData[1], 'FIESC') !== false) {
    //                         foreach ($item['details'][0] as $subject) {
    //                             if (
    //                                 isset($subject['topicShortName'], $subject['topicLongName']) &&
    //                                 !empty($subject['topicShortName']) &&
    //                                 !empty($subject['topicLongName'])
    //                             ) {
    //                                 $year = $this->extractYearFromGroup($groupData[1]);

    //                                 // Creează cheia unică pentru verificare
    //                                 $uniqueKey = $subject['topicShortName'] . '-' . $year;

    //                                 if (!isset($uniqueTopics[$uniqueKey])) {
    //                                     // Adaugă subiectul în array-ul unic
    //                                     $uniqueTopics[$uniqueKey] = [
    //                                         'short_name' => $subject['topicShortName'],
    //                                         'name' => $subject['topicLongName'],
    //                                         'faculty_id' => 1, // ID-ul FIESC
    //                                         'year' => $year,
    //                                     ];
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     // Inserăm subiectele unice în baza de date
    //     if (!empty($uniqueTopics)) {
    //         Subject::insert(array_values($uniqueTopics));
    //     }

    //     $this->command->info('Inserare completă fără duplicate.');
    // }

    /**
     * Extrage anul din informațiile grupei.
     *
     * @param string $groupData
     * @return int
     */


    // private function extractYearFromGroup(string $groupData): int
    // {
    //     if (preg_match('/C an (\d)/', $groupData, $matches)) {
    //         return (int) $matches[1];
    //     }
    //     return 0; // An necunoscut
    // }

    /**
     * Citește fișierul JSON și selectează subiectele distincte.
     *
     * @param string $filePath
     * @return array
     */
    public function run()
    {
        // Citește fișierul JSON
        $json = Storage::get('subgroup_details_2.json');
        $data = json_decode($json, true);
        $uniqueTopics = []; // Array pentru subiecte unice
        $url = 'https://orar.usv.ro/orar/vizualizare/data/facultati.php?json';

         // Obține datele de la endpoint
        $response = Http::withOptions(['verify' => false])->get($url);


         // Verifică dacă request-ul a fost cu succes

        $external_faculties = $response->json();
        $db_faculties = \DB::table('faculties')->get();

        $facultiesMap = [];
        foreach ($external_faculties as $external_faculty) {
            foreach ($db_faculties as $db_faculty) {
            if ($external_faculty['longName'] === $db_faculty->name) {
                $facultiesMap[$external_faculty['id']] = $db_faculty->id;
                break;
            }
            }
        }
        // Loghează maparea facultăților
        \Log::info('Faculties Map:', $facultiesMap);
        if (is_array($data)) {
            \Log::info('Data', $data);
            foreach ($data as $item) {
                if (
                    isset($item['topicShortName'], $item['topicLongName']) &&
                    !empty($item['topicShortName']) &&
                    !empty($item['topicLongName'])
                ) {
                    // Creează cheia unică pentru verificare
                    $uniqueKey = $item['topicLongName'];

                    if (!isset($uniqueTopics[$uniqueKey])) {
                        // Adaugă subiectul în array-ul unic
                        $uniqueTopics[$uniqueKey] = [
                            'short_name' => $item['topicShortName'],
                            'name' => $item['topicLongName'],
                            'year' => $item['studyYear'],
                            'faculty_id' => $facultiesMap[$item['facultyId']], // ID-ul facultății din JSON
                        ];
                    }
                }
            }
        }
        Subject::insert($uniqueTopics);
        //return $uniqueTopics;

    }


}
