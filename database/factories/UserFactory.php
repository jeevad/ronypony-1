<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'role_id' => function () {
            return factory(\App\Models\Role::class)->create()->id;
        },
        'remember_token' => str_random(10),
    ];
});

$factory->state(\App\Models\User::class, 'super_admin', function ($faker) {
    return [
        'role_id' => 1,
    ];
});

$factory->state(\App\Models\User::class, 'admin', function ($faker) {
    return [
        'role_id' => 2,
    ];
});

$factory->state(\App\Models\User::class, 'moderator', function ($faker) {
    return [
        'role_id' => 3,
    ];
});

$factory->state(\App\Models\User::class, 'user', function ($faker) {
    return [
        'role_id' => 4,
    ];
});
