<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Models\Cinema; // To associate with cinemas

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Fetch role IDs indexed by role_title
        $roles = Role::pluck('id', 'role_title');
        
        // Ensure all required roles exist
        $requiredRoles = ['user', 'admin', 'staff', 'superadmin'];
        foreach ($requiredRoles as $role) {
            if (!isset($roles[$role])) {
                $this->command->error("Missing role: {$role}. Please seed the roles table first.");
                return;
            }
        }

        // Fetch companies and cinemas
        $company1 = Company::find(1); // Company ID 1
        $cinema1 = Cinema::find(1); // Cinema ID 1
        $company2 = Company::find(2); // Company ID 2
        $cinema2 = Cinema::find(2); // Cinema ID 2

        // Users to seed for company_id = 1 and cinema_id = 1
        $users = [
            [
                'name' => 'Nancy',
                'email' => 'nancy@gmail.com',
                'phone' => '01147855478',
                'password' => '74108520',
                'role' => 'user',
                'salary' => 4000,
                'company_id' => null,
                'cinema_id' => null,
            ],
            [
                'name' => 'Ahmed',
                'email' => 'ahmed@gmail.com',
                'phone' => '01145822367',
                'password' => '74108520',
                'role' => 'admin',
                'salary' => 5000,
                'company_id' => 1,
                'cinema_id' => 1,
            ],
            [
                'name' => 'Mohsen',
                'email' => 'mohsen@gmail.com',
                'phone' => '01145822369',
                'password' => '74108520',
                'role' => 'staff',
                'salary' => 3000,
                'company_id' => 1,
                'cinema_id' => 1,
            ],
            [
                'name' => 'Asala',
                'email' => 'asala@gmail.com',
                'phone' => '01147855236',
                'password' => '74108520',
                'role' => 'superadmin',
                'salary' => 6000,
                'company_id' => 1,
                'cinema_id' => 1,
            ],

         
            [
                'name' => 'ali',
                'email' => 'ali@gmail.com',
                'phone' => '01145822368',
                'password' => '74108520',
                'role' => 'admin',
                'salary' => 5000,
                'company_id' => 2,
                'cinema_id' => 2,
            ],
            [
                'name' => 'khaled',
                'email' => 'khaled@gmail.com',
                'phone' => '01145822370',
                'password' => '74108520',
                'role' => 'staff',
                'salary' => 3000,
                'company_id' => 2,
                'cinema_id' => 2,
            ],
            [
                'name' => 'farah',
                'email' => 'farah@gmail.com',
                'phone' => '01147855237',
                'password' => '74108520',
                'role' => 'superadmin',
                'salary' => 6000,
                'company_id' => 2,
                'cinema_id' => 2,
            ]
        ];

        // Loop through the users and create them
        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),
                    'role_id' => $roles[$data['role']],
                    'salary' => $data['salary'],  // Add salary
                    'company_id' => $data['company_id'], // Add company_id
                    'cinema_id' => $data['cinema_id'], // Add cinema_id
                ]
            );
        }

        $this->command->info('Users seeded successfully!');
    }
}
