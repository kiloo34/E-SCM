<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenuDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('menu_details')->truncate();
        \DB::table('menu_details')->insert([
            [
                'menu_id' => 1,
                'supply_id' => 1,
                'qty' => 1
            ],
            [
                'menu_id' => 2,
                'supply_id' => 2,
                'qty' => 1
            ],
            [
                'menu_id' => 3,
                'supply_id' => 3,
                'qty' => 1
            ],
            [
                'menu_id' => 5,
                'supply_id' => 5,
                'qty' => 0.25
            ],
            [
                'menu_id' => 6,
                'supply_id' => 4,
                'qty' => 1
            ]
        ]);
    }
}
