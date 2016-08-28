<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderpositionmetasTableSeeder extends Seeder
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
            DB::table('order_position_metas')->insert([
                'order_position_id' => mt_rand(1,3),
                'name' => $faker->word,
                'value' => $faker->sentence,
                'created_at' => date("Y-m-d H:i:s", $created_at),
            ]);
        }
    }
}
