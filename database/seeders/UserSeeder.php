<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'role' => 'admin',
            ],
            [
                'name' => 'IT Manager',
                'email' => 'manager@example.com',
                'role' => 'it-manager',
            ],
            [
                'name' => 'Technician',
                'email' => 'tech@example.com',
                'role' => 'technician',
            ],
            [
                'name' => 'Technician 2',
                'email' => 'tech2@example.com',
                'role' => 'technician',
            ],
            [
                'name' => 'Technician 3',
                'email' => 'tech3@example.com',
                'role' => 'technician',
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'role' => 'user',
            ],
            [
                'name' => 'Regular User 2',
                'email' => 'user2@example.com',
                'role' => 'user',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'), // default password
                    'role' => $data['role'],
                ]
            );
        }
    }
}

