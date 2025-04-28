<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Assuming you have a Role model

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Check if roles already exist, and only insert them if not
        $roles = [
            'user',
            'admin',
            'superadmin',
            'staff',
            'developer', // Added the developer role
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['role_title' => $role], // Check if the role already exists by title
                ['created_at' => now(), 'updated_at' => now()] // Optionally, you can set the timestamps
            );
        }
    }
}
