<?php

namespace App\Modules\Users\Infrastructure\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'Owner', 'created_at' => Carbon::create('2019', '02', '01', '18', '08', '01'), 'updated_at' => Carbon::create('2019', '02', '01', '18', '08', '01')],
            ['id' => 2, 'name' => 'Manager', 'created_at' => Carbon::create('2019', '02', '01', '18', '08', '02'), 'updated_at' => Carbon::create('2019', '02', '01', '18', '08', '02')],
            ['id' => 3, 'name' => 'Employee', 'created_at' => Carbon::create('2019', '02', '01', '18', '08', '02'), 'updated_at' => Carbon::create('2019', '02', '01', '18', '08', '02')],
            ['id' => 4, 'name' => 'Auditor', 'created_at' => Carbon::create('2019', '02', '01', '18', '08', '03'), 'updated_at' => Carbon::create('2019', '02', '01', '18', '08', '03')],
        ];

        DB::table('roles')->insert($roles);
    }
}
