<?php

namespace App\Modules\Products\Domain\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Niño',
                'description' => 'Aplica para menores de 18 años.',
                'price' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Adulto',
                'description' => 'Aplica para cualquier persona mayor de 18 años.',
                'price' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Adulto + Niño',
                'description' => 'Aplica para niños que requieran la asistencia de un adulto.',
                'price' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Adulto 2 x 1',
                'description' => 'Promoción 2 x 1 para adultos después de un pedido.',
                'price' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
