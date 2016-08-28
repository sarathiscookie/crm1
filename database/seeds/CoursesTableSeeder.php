<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CoursesTableSeeder extends Seeder
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
            DB::table('courses')->insert([
                'school_id' => mt_rand(1,3),
                'course_type_id' => mt_rand(1,3),
                'month_begin' => mt_rand(1,5),
                'month_end' => mt_rand(1,5),
                'services' => $faker->sentence,
                'content' => $faker->sentence,
                'unit_lesson' => mt_rand(1,5),
                'unit_rules' => mt_rand(1,5),
                'rounds' => mt_rand(1,5),
                'rentalclub' => $faker->countryCode,
                'free_balls' => $faker->randomLetter,
                'free_range' => $faker->randomLetter,
                'free_putting' => $faker->randomLetter,
                'turnier' => mt_rand(1,5),
                'status' => 'online'
            ]);
        }
    }
}

/*If it is number use*/
/*
 * 'free_balls' => $faker->randomDigit,
 * 'free_range' => $faker->randomDigit,
 * 'free_putting' => $faker->randomDigit,
 */