<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Persona;
use Faker\Generator as Faker;

$factory->define(Persona::class, function (Faker $faker) {
    return [
        'nombre' => $faker->firstName,
        'apellido' => $faker->lastName,
        'telefono' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'direccion' => $faker->streetAddress,
    ];
});
