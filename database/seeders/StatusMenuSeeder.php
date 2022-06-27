<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatusMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('status_menus')->truncate();
        \DB::table('status_menus')->insert([
            [
                'name'      => 'tersedia'
            ],
            [
                'name'      => 'habis'
            ],
        ]);
    }
}
