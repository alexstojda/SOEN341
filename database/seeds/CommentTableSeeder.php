<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 20; $i++) {
            factory(App\Comment::class)->create(['question_id' => random_int(1, App\Question::count()),]);
            factory(App\Comment::class)->create(['answer_id' => random_int(1, App\Answer::count()),]);
        }
    }
}
