<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplyOrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('supply_order_details')->truncate();
        \DB::table('supply_order_details')->insert([
            [
                'supply_order_id' => 1,
                'supply_id' => 1,
                'qty'=> 30,
                'total_harga'=> 24000,
            ],
            [
                'supply_order_id' => 1,
                'supply_id' => 4,
                'qty'=> 50,
                'total_harga'=> 25000,
            ],
            [
                'supply_order_id' => 2,
                'supply_id' => 2,
                'qty'=> 12,
                'total_harga'=> 18000,
            ],
            [
                'supply_order_id' => 2,
                'supply_id' => 3,
                'qty'=> 12,
                'total_harga'=> 18000,
            ],
            [
                'supply_order_id' => 2,
                'supply_id' => 6,
                'qty'=> 12,
                'total_harga'=> 19800,
            ],
        ]);
    }
}
