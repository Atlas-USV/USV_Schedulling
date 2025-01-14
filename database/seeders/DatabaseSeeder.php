<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\UserRoles;
use Illuminate\Database\Seeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\FacultySeeder;
use Database\Seeders\SubjectSeeder;
use Database\Seeders\SubjectsSeeder;
use Database\Seeders\RolePermissions;
use Database\Seeders\UserGroupSeeder;
use Database\Seeders\EvaluationSeeder;
use Database\Seeders\SpecialitySeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\SpecialtiesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            FacultySeeder::class,
            SpecialtiesSeeder::class,
            UserRoles::class,
            PermissionsSeeder::class,
            RolePermissions::class,
            UserSeeder::class,
            GroupSeeder::class,
            RoomSeeder::class,
            UserGroupSeeder::class,
            SubjectsSeeder::class
        ]);
    }
}
