<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class HotelsTableSeeder extends Seeder
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
            DB::table('hotels')->insert([
                'group_id' => mt_rand(1,3),
                'school_id' => mt_rand(1,3),
                'title' => $faker->word,
                'subtitle' => $faker->word,
                'alias' => mt_rand(1000,99999999),
                'description' => $faker->sentence,
                'terms' => $faker->sentence,
                'services' => $faker->sentence,
                'golfdistance' => mt_rand(1,3),
                'stars' => mt_rand(1,3),
                'address' => $faker->streetAddress,
                'coords' => $faker->latitude($min = -90, $max = 90).",".$faker->longitude($min = -180, $max = 180),
                'city' => $faker->city,
                'country' => $faker->streetName,
                'country_short' => $faker->countryCode,
                'nights' => mt_rand(1,3),
                'additional_nights' => 'no',
                'location' => $faker->streetName,
                'status' => 'online',
                'new' => 'yes',
                'blog_link' => 'www.testblog.com',
                'widget' => $faker->sentence,
                'created_at' => date("Y-m-d H:i:s", $created_at)
            ]);
        }
    }
}
