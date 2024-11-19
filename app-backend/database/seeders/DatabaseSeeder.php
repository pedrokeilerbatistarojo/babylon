<?php

namespace Database\Seeders;

use App\Modules\Users\Domain\Models\User;
use App\Modules\Users\Infrastructure\Seeders\RoleSeeder;
use App\Modules\Users\Infrastructure\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            RoleSeeder::class,
            UserSeeder::class,
        ];

        $this->call($seeders);
    }
}
