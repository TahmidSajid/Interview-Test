<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Test Admin 1',
                'email' => 'admin@mail.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
