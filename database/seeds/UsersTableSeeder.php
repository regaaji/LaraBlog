<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Rega Aji',
            'username' => 'regaaji',
            'password' => bcrypt('password'),
            'email' => 'regaajiprayogo@gmail.com',
        ]);
    }
}
