<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'church_id' => 1,
        'person_id' => 1,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(\App\Models\State::class, function (\Faker\Generator $faker){
    return [];
});

$factory->define(\App\Models\Role::class, function (\Faker\Generator $faker){
   return [];
});

$factory->define(\App\Models\Person::class, function (\Faker\Generator $faker){

    return [
        'name' => $faker->name,
        'lastName' => $faker->lastName,
        'imgProfile' => 'uploads/profile/noimage.png',
        'tel' => $faker->numerify('#############'),
        'role_id' => 1,
        'gender' => 'M',
        'dateBirth' => '1989-05-26',
        'cpf' => $faker->creditCardNumber,
        'tag' => 'adult',
        'street' => $faker->streetAddress,
        'neighborhood' => $faker->word,
        'city' => $faker->city,
        'zipCode' => random_int(10000, 100000),
        'state' => 'SP'
    ];

});

$factory->define(\App\Models\Church::class, function (\Faker\Generator $faker){
   return [
       'name' => $faker->name,
       'email' => $faker->safeEmail,
       'responsible_id' => 1,
       'tel' =>  $faker->numerify('#############'),
       'cnpj' => '94121653000172'
   ];
});

$factory->define(\App\Models\Responsible::class, function (\Faker\Generator $faker){

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'role_id' => 5
    ];
});
