<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('roles')->truncate();
        \DB::table('roles')->insert([
            [
                'name' => 'manager'
            ],
            [
                'name' => 'kasir'
            ],
            [
                'name' => 'supplier'
            ]
        ]);
    }
}
