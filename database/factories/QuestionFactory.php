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

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        'author_id' => random_int(1, App\User::count()),
        'title' => $faker->sentence(),
        'body' => $faker->paragraph(),
    ];
});
