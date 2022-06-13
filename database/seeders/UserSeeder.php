<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('users')->truncate();
        \DB::table('users')->insert([
            [
                'username' => 'manager23',
                'name' => 'manager',
                'email' => 'manager@email.com',
                'password' => bcrypt('12345678'),
                'role_id' => 1
            ],
            [
                'username' => 'kasir23',
                'name' => 'kasir',
                'email' => 'kasir@email.com',
                'password' => bcrypt('12345678'),
                'role_id' => 2
            ],
            [
                'username' => 'supplier23',
                'name' => 'supplier',
                'email' => 'supplier@email.com',
                'password' => bcrypt('12345678'),
                'role_id' => 3
            ],
        ]);
    }
}
