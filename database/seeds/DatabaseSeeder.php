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

        $this->call(FrequencyTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ResponsibleTableSeeder::class);
        $this->call(ChurchTableSeeder::class);
        $this->call(PeopleTableSeeder::class);
        $this->call(UsersTableSeeder::class);

    }
}
