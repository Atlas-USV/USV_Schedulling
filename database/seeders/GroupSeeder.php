<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Speciality;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $speciality = Speciality::first();

        Group::create(['name' => '3111', 'speciality_id' => $speciality->id, 'study_year' => 1,  'number' => 1]);
        Group::create(['name' => '3121', 'speciality_id' => $speciality->id, 'study_year' => 2,  'number' => 2]);
    }
}
