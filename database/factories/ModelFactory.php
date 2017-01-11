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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'church_id' => 1,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'imgProfile' => 'uploads/profile/noimage.png',
        'tel' => $faker->numerify('###'),
        'role' => $faker->jobTitle,
        'gender' => 'M',
        'dateBirth' => $faker->date('Y-m-d'),
        'cpf' => $faker->creditCardNumber,
        'street' => $faker->streetAddress,
        'neighborhood' => $faker->word,
        'city' => $faker->city,
        'zipCode' => random_int(10000, 100000),
        'state' => 'SP'
    ];
});

$factory->define(\App\Models\State::class, function (\Faker\Generator $faker){
    return [];
});
