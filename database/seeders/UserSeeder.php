<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Assign role to the user
        $user->assignRole('admin'); // or 'user'

        // Create another user
        $user2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
        ]);

         // Assign role to the second user
         $user2->assignRole('student');

         // Create another user
        $user3 = User::create([
            'name' => 'Jane Doe',
            'email' => 'cocris.iulian3@gmail.com',
            'password' => bcrypt('password123'),
        ]);

         // Assign role to the second user
         $user3->assignRole('student');

        // $user = User::where('email', 'test@mail.com')->first();

        // if ($user) {
        //     // Assign the permission
        //     $permission = Permission::findByName('propose_exam');
        //     $user->givePermissionTo($permission);
        // }
    }
}
