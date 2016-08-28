<?php

use Illuminate\Database\Seeder;
use Laraspace\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'iamsarath1986@gmail.com',
            'name' => 'Iamsarath',
            'password' => bcrypt('admin@123')
        ]);

        User::create([
            'email' => 'sarath@gmail.com',
            'name' => 'Sarath',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'rahul@gmail.com',
            'name' => 'Rahul',
            'password' => bcrypt('123456')
        ]);
    }
}
