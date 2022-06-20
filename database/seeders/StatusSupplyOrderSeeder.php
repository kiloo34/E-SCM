<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatusSupplyOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('status_supply_orders')->truncate();
        \DB::table('status_supply_orders')->insert([
            [
                'name'      => 'menunggu konfirmasi'
            ],
            [
                'name'      => 'dikonfirmasi'
            ],
            [
                'name'      => 'dikirim'
            ],
            [
                'name'      => 'keranjang'
            ],
            [
                'name'      => 'selesai'
            ],
            [
                'name'      => 'batal'
            ],
        ]);
    }
}
