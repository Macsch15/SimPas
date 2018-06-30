<?php

use Faker\Generator as Faker;

$factory->define(\SimPas\Models\PastebinRecord::class, function (Faker $faker) {
    return [
        'unique_id'                   => str_random(15),
        'user_id'                     => mt_rand(10, 50),
        'title'                       => $faker->title,
        'content'                     => $faker->text,
        'disable_syntax_highlighting' => $faker->boolean,
        'is_private'                  => $faker->boolean,
    ];
});
