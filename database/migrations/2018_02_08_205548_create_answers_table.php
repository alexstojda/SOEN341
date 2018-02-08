<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            //Which question this answer belongs to
            $table->integer('question_id')->unsigned()->nullable();
            //User that posted this answer
            $table->integer('user_id')->unsigned();
            //Answer content
            $table->multiLineString('answer_body');
            //Is this the best answer
            $table->boolean('isBestAnswer');
            // Generate timestamps for update and creation
            $table->timestamps('created_at');


            $table->foreign('user_id','question_id')->references('id')->on('users')->onDelete('set null')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
