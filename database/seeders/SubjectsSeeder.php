<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
      

        $json = Storage::get('subgrupe.json');
        $data = json_decode($json, true);
        $topics = [];
        if (is_array($data)) {
            foreach ($data as $item) {
                if (isset($item['topicShortName']) && (!empty($item['topicShortName']) || $item['topicShortName'] != null)) {
                    $topics[$item['topicLongName']] = [
                        'short_name' => $item['topicShortName'],
                        'name' => $item['topicLongName'],
                    ];
                }
            }
        }

        Subject::insert(array_map(function ($topic) {
            return [
            'short_name' => $topic['short_name'],
            'name' => $topic['name'],
            ];
        }, $topics));
    }
}
