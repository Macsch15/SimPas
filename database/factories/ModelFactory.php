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

$factory->define(\SimPas\Repository\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => '$2y$10$ubBu6t8pMAtLriTy8WI0P./6jAzNPuoKDTJcCixY9Qbyl9VNk9R8W',
        'remember_token' => str_random(10),
    ];
});

$factory->define(\SimPas\Repository\PastebinRecord::class, function (Faker\Generator $faker) {
    return [
        'unique_id' => str_random(15),
        'user_id' => mt_rand(10, 50),
        'title' => $faker->title,
        'content' => $faker->text,
        'disable_syntax_highlighting' => $faker->boolean,
        'is_private' => $faker->boolean
    ];
});
