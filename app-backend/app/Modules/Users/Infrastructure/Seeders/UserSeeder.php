<?php

namespace App\Modules\Users\Infrastructure\Seeders;

use App\Modules\Users\Domain\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Owner User',
                'email' => 'owner@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1, // Owner
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // Manager
            ],
            [
                'name' => 'Employee User',
                'email' => 'employee@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3, // Employee
            ],
            [
                'name' => 'Auditor User',
                'email' => 'auditor@example.com',
                'password' => Hash::make('password'),
                'role_id' => 4, // Auditor
            ],
        ];

        foreach ($users as &$user) {
            $user['username'] = Str::of($user['name'])
                ->lower()
                ->replace(' ', '')
                ->ascii()
                ->value();
            User::create($user);
        }
    }
}
