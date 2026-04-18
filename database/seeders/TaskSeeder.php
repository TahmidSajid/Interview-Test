<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_ids = User::pluck('id')->toArray();

        $statuses = ['pending', 'in_progress', 'completed'];

        for ($i = 1; $i <= 10; $i++) {

            Task::create([
                'user_id' => $user_ids[array_rand($statuses)],
                'title' => 'Task ' . $i,
                'description' => 'Description for task ' . $i,
                'status' => $statuses[array_rand($statuses)],
                'due_date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
            ]);
        }
    }
}
