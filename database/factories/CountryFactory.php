<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Country::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->country,
        'code' => $faker->unique()->countryCode,
        'phone_code' => $faker->randomElement([
            '+91',
            '+1',
            '+86',
        ]),
        'currency_code' => $faker->currencyCode,
        'lang_code' => $faker->languageCode,
    ];
});
