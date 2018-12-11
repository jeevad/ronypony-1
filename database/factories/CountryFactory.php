<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Country::class, function (Faker $faker) {
    $name = $faker->unique()->randomElement([
        'India',
        'US',
        'China',
    ]);
    if ($name === 'India') {
        $code = 'IN';
        $phoneCode = '+91';
        $currencyCode = 'INR';
        $langCode = 'hi';
    }
    if ($name === 'US') {
        $code = 'US';
        $phoneCode = '+1';
        $currencyCode = 'USD';
        $langCode = 'en';
    }
    if ($name === 'China') {
        $code = 'CN';
        $phoneCode = '+86';
        $currencyCode = 'CNY';
        $langCode = 'en';
    }
    return [
        'name' => $name,
        'code' => $code,
        'phone_code' => $phoneCode,
        'currency_code' => $currencyCode,
        'lang_code' => $langCode,
    ];
});
