<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('supplies')->truncate();
        \DB::table('supplies')->insert([
            [
                'name'  => 'kopi sachet',
                'stock' => 24,
                'price' => 800,
                'status'=> 1
            ],
            [
                'name'  => 'chocolatos',
                'stock' => 55,
                'price' => 1500,
                'status'=> 1
            ],
            [
                'name'  => 'chocolatos matcha',
                'stock' => 43,
                'price' => 1500,
                'status'=> 1
            ],
            [
                'name'  => 'tahu',
                'stock' => 50,
                'price' => 500,
                'status'=> 1
            ],
            [
                'name'  => 'tempe',
                'stock' => 10,
                'price' => 5000,
                'status'=> 2
            ],
            [
                'name'  => 'beng beng coklat',
                'stock' => 120,
                'price' => 1650,
                'status'=> 1
            ],
        ]);
    }
}
