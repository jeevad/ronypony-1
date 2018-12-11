<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Role::class, function (Faker $faker) {
    $name = $faker->randomElement([
        'Super Admin',
        'Admin',
        'Moderator',
        'User',
    ]);
    return [
        'name' => $name,
        'slug' => str_slug($name),
    ];
});
