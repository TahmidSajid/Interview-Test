<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Test User 1',
                'email' => 'test1@mail.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Test User 2',
                'email' => 'test2@mail.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Test User 3',
                'email' => 'test3@mail.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
