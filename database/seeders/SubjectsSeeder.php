<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SubjectsSeeder extends Seeder
{
    /**
     * Rulează seeder-ul.
     */
    public function run()
    {
        // Citește fișierul JSON
        $json = Storage::get('subgroup_details.json');
        $data = json_decode($json, true);
        $uniqueTopics = []; // Array pentru subiecte unice

        if (is_array($data)) {
            foreach ($data as $item) {
                if (isset($item['details'][1])) {
                    $groups = $item['details'][1];
                    foreach ($groups as $groupId => $groupData) {
                        if (strpos($groupData[1], 'FIESC') !== false) {
                            foreach ($item['details'][0] as $subject) {
                                if (
                                    isset($subject['topicShortName'], $subject['topicLongName']) &&
                                    !empty($subject['topicShortName']) &&
                                    !empty($subject['topicLongName'])
                                ) {
                                    $year = $this->extractYearFromGroup($groupData[1]);

                                    // Creează cheia unică pentru verificare
                                    $uniqueKey = $subject['topicShortName'] . '-' . $year;

                                    if (!isset($uniqueTopics[$uniqueKey])) {
                                        // Adaugă subiectul în array-ul unic
                                        $uniqueTopics[$uniqueKey] = [
                                            'short_name' => $subject['topicShortName'],
                                            'name' => $subject['topicLongName'],
                                            'faculty_id' => 1, // ID-ul FIESC
                                            'year' => $year,
                                        ];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // Inserăm subiectele unice în baza de date
        if (!empty($uniqueTopics)) {
            Subject::insert(array_values($uniqueTopics));
        }

        $this->command->info('Inserare completă fără duplicate.');
    }

    /**
     * Extrage anul din informațiile grupei.
     *
     * @param string $groupData
     * @return int
     */
    private function extractYearFromGroup(string $groupData): int
    {
        if (preg_match('/C an (\d)/', $groupData, $matches)) {
            return (int) $matches[1];
        }
        return 0; // An necunoscut
    }
}
