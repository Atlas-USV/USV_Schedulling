<?php

namespace Database\Seeders;

use App\Shared\ERoles;
use App\Shared\EPermissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => ERoles::ADMIN->value]);
        $secretaryRole = Role::firstOrCreate(['name' => ERoles::SECRETARY->value]);

        $adminRole->givePermissionTo([
            EPermissions::CREATE_EXAMS->value,
            EPermissions::EDIT_EXAMS->value,
            EPermissions::DELETE_EXAMS->value,
            EPermissions::VIEW_USERS->value,
            EPermissions::EDIT_DELETE_USER->value,

        ]);
        $secretaryRole->givePermissionTo([
            EPermissions::CREATE_EXAMS->value,
            EPermissions::EDIT_EXAMS->value,
            EPermissions::DELETE_EXAMS->value,
            EPermissions::VIEW_USERS->value,
            EPermissions::EDIT_DELETE_USER->value,

        ]);
    }
}
