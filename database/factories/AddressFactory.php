<?php

use App\Models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(\App\Models\User::class)->create()->id;
        },
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'office_name' => $faker->company,
        'email' => $faker->safeEmail,
        'phone_number' => random_mobile_number(),
        'locality' => $faker->streetAddress,
        'address' => $faker->address,
        'city' => $faker->city,
        'state_id' => function () {
            return factory(\App\Models\State::class)->create()->id;
        },
        'country_id' => function () {
            return factory(\App\Models\Country::class)->create()->id;
        },
        'zip_code' => $faker->postcode,
        'type' => $faker->randomElement(['SHIPPING', 'BILLING']),
        'default' => false,
    ];
});

$factory->state(Address::class, 'default', function ($faker) {
    return [
        'default' => true,
    ];
});
