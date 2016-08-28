<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderpassengersTableSeeder extends Seeder
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
            DB::table('order_passengers')->insert([
                'order_id' => mt_rand(1,3),
                'customer_id' => mt_rand(1,3),
                'invoice' => 'yes',
                'created_at' => date("Y-m-d H:i:s", $created_at)
            ]);
        }
    }
}
