<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\Speciality;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $engineering = Faculty::where('short_name', 'ENG')->first();
        $sciences = Faculty::where('short_name', 'SCI')->first();

        Speciality::create(['name' => 'Computer Science', 'short_name' => 'CS', 'faculty_id' => $engineering->id]);
        Speciality::create(['name' => 'Mechanical Engineering', 'short_name' => 'ME', 'faculty_id' => $engineering->id]);
        Speciality::create(['name' => 'Physics', 'short_name' => 'PHY', 'faculty_id' => $sciences->id]);
    }
}
