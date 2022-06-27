<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplyOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('supply_orders')->truncate();
        \DB::table('supply_orders')->insert([
            [
                'total' => 49000,
                'status'=> 1
            ],
            [
                'total' => 55800,
                'status'=> 2
            ],
        ]);
    }
}
