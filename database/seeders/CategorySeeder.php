<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('categories')->truncate();
        \DB::table('categories')->insert([
            [
                'name' => 'makanan'
            ],
            [
                'name' => 'minuman'
            ],
            [
                'name' => 'cemilan'
            ]
        ]);
    }
}
