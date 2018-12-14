<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\State::class, function (Faker $faker) {
    $name = $faker->unique()->state;
    return [
        'country_id' => function () {
            return factory(\App\Models\Country::class)->create()->id;
        },
        'name' => $name,
        'code' => str_slug($name),
    ];
});
