<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrdersTableSeeder extends Seeder
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
            $payed_at   = mt_rand( strtotime("Jun 01 2016"), strtotime("Aug 01 2016") );
            $cancelled_at = mt_rand( strtotime("Jul 01 2016"), strtotime("Aug 01 2016") );
            DB::table('orders')->insert([
                'invoice_id' => mt_rand(111111, 999999),
                'status' => 'offered',
                'source' => 'website',
                'payed_at' => date("Y-m-d", $payed_at),
                'created_at' => date("Y-m-d H:i:s", $payed_at),
            ]);
        }
    }
}
