<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Expr\Assign;
use Spatie\Permission\Contracts\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an Admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'password' => bcrypt('password'),
            'email' => 'admin@example.com',
        ]);

        // Assign the admin role to the user
        $admin->assignRole('admin');

        // Create a Supervisor user
        $supervisor = User::factory()->create([
            'name' => 'Supervisor User',
            'password' => bcrypt('password'),
            'email' => 'supervisor@example.com',
        ]);

        // Assign the supervisor role to the user
        $supervisor->assignRole('supervisor');
    }
}
