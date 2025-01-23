<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'teacher', 'secretary', 'student'];

        foreach ($roles as $role) {
            // Verifică dacă rolul există deja
            if (!Role::where('name', $role)->exists()) {
                Role::create(['name' => $role]);
            } else {
                \Log::info("Role `{$role}` already exists.");
            }
        }
    }
}
