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
            $table->engine = 'InnoDB';
            //Answer identifier
            $table->increments('id');
            //Which question this answer belongs to
            $table->integer('question_id')->unsigned();
            //User that posted this answer
            $table->integer('author_id')->unsigned()->nullable();
            //Answer content
            $table->mediumText('body');
            //Keep track of the feedback for this answer
            $table->integer('votes')->default(0);
            //Generate timestamps for update and creation
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('answers');
        Schema::enableForeignKeyConstraints();
    }
}