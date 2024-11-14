<?php

namespace Database\Seeders;

use App\Models\Subgroup;
use App\Models\Speciality;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubgroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $speciality = Speciality::first();

        Subgroup::create(['name' => 'Group A', 'speciality_id' => $speciality->id, 'study_year' => 1, 'index' => 'A1']);
        Subgroup::create(['name' => 'Group B', 'speciality_id' => $speciality->id, 'study_year' => 2, 'index' => 'B2']);
    }
}
