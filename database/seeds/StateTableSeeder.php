<?php

use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\State::class, 1)->create([
           'initials' => "AC",
            'state' => 'Acre'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "AL",
            'state' => 'Alagoas'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "AP",
            'state' => 'Amapá'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "AM",
            'state' => 'Amazonas'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "BA",
            'state' => 'Bahia'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "CE",
            'state' => 'Ceará'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "DF",
            'state' => 'Distrito Federal'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "ES",
            'state' => 'Espírito Santo'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "GO",
            'state' => 'Goías'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "MA",
            'state' => 'Maranhão'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "MT",
            'state' => 'Mato Grosso'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "MS",
            'state' => 'Mato Grosso do Sul'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "PB",
            'state' => 'Paraíba'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "PR",
            'state' => 'Paraná'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "PE",
            'state' => 'Pernambuco'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "PI",
            'state' => 'Piauí'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "RJ",
            'state' => 'Rio de Janeiro'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "RN",
            'state' => 'Rio Grande do Norte'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "RS",
            'state' => 'Rio Grande do Sul'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "RO",
            'state' => 'Rondônia'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "RR",
            'state' => 'Roraima'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "SC",
            'state' => 'Santa Catarina'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "SP",
            'state' => 'São Paulo'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "SE",
            'state' => 'Sergipe'
        ]);

        factory(\App\Models\State::class, 1)->create([
            'initials' => "TO",
            'state' => 'Tocantins'
        ]);
    }
}
