<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomersTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(CoursedurationsTableSeeder::class);
        $this->call(CoursetypesTableSeeder::class);
        $this->call(OrderpassengersTableSeeder::class);
        $this->call(OrderpositionsTableSeeder::class);
        $this->call(OrderpositionmetasTableSeeder::class);
        $this->call(SchoolsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(CourseoptionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(HotelsTableSeeder::class);
        $this->call(OffersTableSeeder::class);
    }
}
