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
                'name'      => 'kopi sachet',
                'stock'     => 24
            ],
            [
                'name'      => 'chocolatos',
                'stock'     => 55
            ],
            [
                'name'      => 'chocolatos matcha',
                'stock'     => 43
            ],
            [
                'name'      => 'tahu',
                'stock'     => 50
            ],
            [
                'name'      => 'tempe',
                'stock'     => 10
            ],
        ]);
    }
}
