<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assignment;
use App\Models\User;
use Carbon\Carbon;

class AssignmentsTableSeeder extends Seeder
{
    public function run()
    {
        // Fetch staff users
        $staffMembers = User::where('role_id', 4)->get(); // Assuming role_id 4 is for staff
        
        // Define sample tasks
        $tasks = [
            'Prepare Hall',
            'Check Tickets',
            'Clean Hall',
            'Help Customers',
            'Manage Supplies'
        ];

        // Loop through the staff and assign tasks
        foreach ($staffMembers as $staff) {
            foreach ($tasks as $task) {
                // Assign task with a random completion status
                Assignment::create([
                    'staff_id' => $staff->id,
                    'task_name' => $task,
       
                    'is_completed' => rand(0, 1), // Randomly assign as completed or not
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }

        $this->command->info('Assignments table seeded!');
    }
}
