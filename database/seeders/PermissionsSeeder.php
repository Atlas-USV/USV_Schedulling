<?php

namespace Database\Seeders;
use APP\Enums;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::create(['name' => EPermission::VIEW_EXAMS->value]);
        Permission::create(['name' => EPermission::CREATE_EXAMS->value]);
        Permission::create(['name' => EPermission::EDIT_EXAMS->value]);
        Permission::create(['name' => EPermission::DELETE_EXAMS->value]);
    }
}
