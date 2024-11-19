<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Subject::create(['name' => 'Mathematics', 'short_name' => 'MATH']);
        Subject::create(['name' => 'Physics', 'short_name' => 'PHYS']);
        Subject::create(['name' => 'Computer Science', 'short_name' => 'CS']);
    }
}
