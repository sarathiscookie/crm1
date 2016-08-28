<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SchoolsTableSeeder extends Seeder
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
            DB::table('schools')->insert([
                'group_id' => mt_rand(1,3),
                'title' => $faker->word,
                'subtitle' => $faker->word,
                'alias' => mt_rand(1000,99999999),
                'description' => $faker->sentence,
                'address' => $faker->streetAddress,
                'coords' => $faker->latitude($min = -90, $max = 90).",".$faker->longitude($min = -180, $max = 180),
                'city' => $faker->city,
                'location' => $faker->streetName,
                'country' => $faker->countryCode,
                'status' => 'online',
                'holes' => mt_rand(1,10),
                'training' => mt_rand(1,10),
                'duration' => mt_rand(1,10),
                'flex_booking' => 'yes',
                'new' => 'yes',
                'created_at' => date("Y-m-d H:i:s", $created_at),
            ]);
        }
    }
}
