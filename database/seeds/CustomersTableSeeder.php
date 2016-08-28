<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomersTableSeeder extends Seeder
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
            $birthdate   = mt_rand( strtotime("Jan 01 2016"), strtotime("Aug 01 2016") );
            $createddate = mt_rand( strtotime("Jul 01 2016"), strtotime("Aug 01 2016") );
            DB::table('customers')->insert([
                'firstname' => $faker->firstNameMale,
                'lastname' => $faker->lastName,
                'street' => $faker->streetName,
                'postal' => $faker->postcode,
                'city' => $faker->city,
                'country' => $faker->country,
                'phone' => mt_rand(1111111111, 9999999999),
                'mail' => $faker->email,
                'birthdate' => date("Y-m-d", $birthdate),
                'status' => 'customer',
                'counterpart' => 'yes',
                'created_at' => date("Y-m-d H:i:s", $createddate),
            ]);
        }
    }
}
