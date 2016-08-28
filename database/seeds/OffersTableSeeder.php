<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class OffersTableSeeder extends Seeder
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
            DB::table('offers')->insert([
                'hotel_id' => mt_rand(1,3),
                'school_id' => mt_rand(1,3),
                'title' => $faker->word,
                'subtitle' => $faker->word,
                'alias' => mt_rand(1000,99999999),
                'kurzleistungen' => $faker->sentence,
                'services' => $faker->sentence,
                'description' => $faker->sentence,
                'header' => $faker->sentence,
                'footer' => $faker->sentence,
                'type' => $faker->word,
                'type_date' => 'timerange',
                'course' => 'no',
                'discount' => mt_rand(10,30),
                'date_begin' => date("Y-m-d H:i:s", $created_at),
                'date_end' => date("Y-m-d H:i:s", $created_at),
                'status' => 'online',
                'created_at' => date("Y-m-d H:i:s", $created_at)
            ]);
        }
    }
}
