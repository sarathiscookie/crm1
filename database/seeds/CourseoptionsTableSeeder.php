<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CourseoptionsTableSeeder extends Seeder
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
            DB::table('course_options')->insert([
                'course_id' => mt_rand(1,3),
                'course_duration_id' => mt_rand(1,3),
                'price' => $faker->randomNumber(2),
                'profit' => $faker->randomNumber(2),
                'profit_solo' => $faker->randomNumber(2),
                'pseudo_price' => $faker->randomNumber(2),
                'price_solo' => $faker->randomNumber(2),
                'pseudo_price_solo' => $faker->randomNumber(2),
                'discount' => $faker->randomNumber(2),
                'status' => 'online'
            ]);
        }
    }
}