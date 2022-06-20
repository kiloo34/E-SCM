<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('menus')->truncate();
        \DB::table('menus')->insert([
            [
                'name' => 'kopi',
                'harga' => 3000,
                'stock' => 24,
                'kategori_id' => 2
            ],
            [
                'name' => 'chocolatos coklat',
                'harga' => 5000,
                'stock' => 55,
                'kategori_id' => 2
            ],
            [
                'name' => 'chocolatos matcha',
                'harga' => 5000,
                'stock' => 43,
                'kategori_id' => 2
            ],
            [
                'name' => 'sate usus',
                'harga' => 1000,
                'stock' => 25,
                'kategori_id' => 3
            ],
            [
                'name' => 'tempe bacem',
                'harga' => 2000,
                'stock' => 25,
                'kategori_id' => 3
            ],
            [
                'name' => 'tahu bacem',
                'harga' => 2000,
                'stock' => 25,
                'kategori_id' => 3
            ],
            [
                'name' => 'nasi kucing',
                'harga' => 5000,
                'stock' => 15,
                'kategori_id' => 1
            ],
            [
                'name' => 'nasi uduk',
                'harga' => 10000,
                'stock' => 10,
                'kategori_id' => 1
            ]
        ]);
    }
}
