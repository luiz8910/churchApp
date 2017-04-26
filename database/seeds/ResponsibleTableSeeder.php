<?php

use Illuminate\Database\Seeder;

class ResponsibleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Responsible::class, 1)->create([]);
    }
}
