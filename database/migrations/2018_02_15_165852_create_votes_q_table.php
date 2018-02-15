<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesQTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes_q', function (Blueprint $table) {
            //Which question was voted on
            $table->integer('question_id')->unsigned();
            //User that voted
            $table->integer('author_id')->unsigned();
            //what they voted (false is down)
            $table->boolean('vote');
            //Generate timestamps for update and creation
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['question_id', 'author_id']);
        });

        Schema::table('vote_q', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes_q');
    }
}
