<?php

use Faker\Generator as Faker;

$factory->define(\SimPas\Models\User::class, function (Faker $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => '$2y$10$ubBu6t8pMAtLriTy8WI0P./6jAzNPuoKDTJcCixY9Qbyl9VNk9R8W',
        'remember_token' => str_random(10),
    ];
});
