<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\FacultySeeder;
use Database\Seeders\SubjectSeeder;
use Database\Seeders\SubgroupSeeder;
use Database\Seeders\EvaluationSeeder;
use Database\Seeders\SpecialitySeeder;
use Database\Seeders\UserSubgroupSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            FacultySeeder::class,
            SpecialitySeeder::class,
            UserRoles::class,
            UserSeeder::class,
            SubjectSeeder::class,
            SubgroupSeeder::class,
            RoomSeeder::class,
            EvaluationSeeder::class,
            UserSubgroupSeeder::class,
        ]);
    }
}
