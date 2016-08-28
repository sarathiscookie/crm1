<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderpositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,10) as $index) {
            $created_at   = mt_rand( strtotime("Jul 01 2016"), strtotime("Aug 01 2016") );
            DB::table('order_positions')->insert([
                'order_id' => mt_rand(1,3),
                'quantity' => mt_rand(4,20),
                'title' => $faker->word,
                'description' => $faker->sentence,
                'price' => mt_rand(80,150),
                'cost' => mt_rand(10,79),
                'type' => 'course',
                'created_at' => date("Y-m-d H:i:s", $created_at),
            ]);
        }
    }
}
