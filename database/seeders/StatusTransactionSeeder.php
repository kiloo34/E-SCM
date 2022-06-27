<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatusTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('status_transactions')->truncate();
        \DB::table('status_transactions')->insert([
            [
                'name'      => 'belum dibayar'
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
