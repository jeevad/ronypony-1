<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\State::class, function (Faker $faker) {
    $name = $faker->unique()->state;
    return [
        'country_id' => 1,
        'name' => $name,
        'code' => str_slug($name),
    ];
});
