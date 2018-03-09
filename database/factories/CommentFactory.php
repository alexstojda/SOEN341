<?php

    use Faker\Generator as Faker;

    $factory->define(App\Comment::class, function(Faker $faker) {
        return [
            'author_id'   => random_int(1, App\User::count()),
            'question_id' => null,
            'answer_id'   => null,
            'body'        => $faker->paragraph(),
        ];
    });