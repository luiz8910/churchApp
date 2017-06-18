<?php

use Illuminate\Database\Seeder;

class FrequencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Frequency::class, 1)->create([
            'frequency' => 'Encontro Único'
        ]);

        factory(\App\Models\Frequency::class, 1)->create([
            'frequency' => 'Diário'
        ]);

        factory(\App\Models\Frequency::class, 1)->create([
            'frequency' => 'Quinzenal'
        ]);

        factory(\App\Models\Frequency::class, 1)->create([
            'frequency' => 'Semanal'
        ]);

        factory(\App\Models\Frequency::class, 1)->create([
            'frequency' => 'Mensal'
        ]);
    }
}
