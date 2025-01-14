<?php

namespace Database\Seeders;
use App\Shared\EPermissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::firstOrCreate(['name' => EPermissions::VIEW_EXAMS->value]);
        Permission::firstOrCreate(['name' => EPermissions::CREATE_EXAMS->value]);
        Permission::firstOrCreate(['name' => EPermissions::EDIT_EXAMS->value]);
        Permission::firstOrCreate(['name' => EPermissions::DELETE_EXAMS->value]);
        Permission::firstOrCreate(['name' => EPermissions::MANAGE_USERS->value]);
        Permission::firstOrCreate(['name' => EPermissions::PROPOSE_EXAM->value]);
        Permission::firstOrCreate(['name' => EPermissions::VIEW_USERS->value]);
        Permission::firstOrCreate(['name' => EPermissions::EDIT_DELETE_USER->value]);
        }
}
