<?php

use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'author_id' => function () {
            return rand(1, \App\User::count());
        },
        'question_id' => function() {
            return rand(1, \App\Question::count());
        },
        'body' => $faker->paragraph(),
    ];
});