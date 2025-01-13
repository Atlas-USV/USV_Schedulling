<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
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

<<<<<<< Updated upstream
        // Assign role to the user
        $user->assignRole('admin'); // or 'user'

        // Create another user
=======
        //Assign role to the user
        $user->assignRole('admin'); // or 'user'

        //Create another user
>>>>>>> Stashed changes
        $user2 = User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
        ]);

<<<<<<< Updated upstream
        // Assign role to the second user
        $user2->assignRole('student');
=======
        //Assign role to the second user
        $user2->assignRole('student');
        
        //Create another user
        $user3 = User::create([
            'name' => 'John Dane',
            'email' => 'dane@example.com',
            'password' => bcrypt('password123'),
        ]);

        //Assign role to the second user
        $user3->assignRole('teacher');

        $user4 = User::create([
            'name' => 'Alice Smith',
            'email' => 'alice.smith@example.com',
            'password' => bcrypt('password123'),
        ]);
        
        // Assign role to the user
        $user4->assignRole('teacher');
        
        $user5 = User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob.johnson@example.com',
            'password' => bcrypt('password123'),
        ]);
        
        // Assign role to the user
        $user5->assignRole('teacher');
        

        //$user = User::where('email', 'test@mail.com')->first();

        /*if ($user) {
            // Assign the permission
            $permission = Permission::findByName('propose_exam');
            $user->givePermissionTo($permission);
        }*/
>>>>>>> Stashed changes
    }
}
