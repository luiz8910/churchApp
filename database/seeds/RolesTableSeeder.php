<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Role::class, 1)->create([
            'name' => 'Lider'
        ]);

        factory(\App\Models\Role::class, 1)->create([
            'name' => 'Membro'
        ]);

        factory(\App\Models\Role::class, 1)->create([
            'name' => 'Visitante'
        ]);

        factory(\App\Models\Role::class, 1)->create([
            'name' => 'Financeiro'
        ]);

        factory(\App\Models\Role::class, 1)->create([
            'name' => 'Administrador'
        ]);
    }
}
