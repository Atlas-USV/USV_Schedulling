<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Subgroup;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSubgroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::first();
        $subgroup = Subgroup::first();

        $user->subgroups()->attach($subgroup->id);
    }
}
