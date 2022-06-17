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
                'name'      => 'kopi abc',
                'stock'     => 52
            ],
            [
                'name'      => 'chocolatos',
                'stock'     => 24
            ],
            [
                'name'      => 'chocolatos matcha',
                'stock'     => 15
            ],
        ]);
    }
}
