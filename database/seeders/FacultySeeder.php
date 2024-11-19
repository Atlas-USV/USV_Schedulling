<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Faculty::create(['name' => 'Engineering', 'short_name' => 'ENG']);
        Faculty::create(['name' => 'Sciences', 'short_name' => 'SCI']);
        Faculty::create(['name' => 'Humanities', 'short_name' => 'HUM']);
    }
}
