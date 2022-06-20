<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatusSupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('status_supplies')->truncate();
        \DB::table('status_supplies')->insert([
            [
                'name'      => 'tersedia'
            ],
            [
                'name'      => 'tidak tersedia'
            ],
        ]);
    }
}
