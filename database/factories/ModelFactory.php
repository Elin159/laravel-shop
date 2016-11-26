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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'nickname' => $faker->name,
        'avatar' => $faker->imageUrl(256,256)
    ];
});

$factory->define(\App\Mode\UserAuth::class, function (Faker\Generator $faker) {
    $user_id = \App\User::lists('id')->toArray();
    return [
        'user_id' => $faker->randomElement($user_id),
        'identity' => 2,
        'identifier' => $faker->safeEmail,
        'credential' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});


