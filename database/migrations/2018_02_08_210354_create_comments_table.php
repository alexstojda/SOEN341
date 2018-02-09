<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            //Comment identifier
            $table->increments('id');
            //Question that this comment is related to or null
            $table->integer('question_id')->unsigned()->nullable();
            //Answer that this comment is related to or null
            $table->integer('answer_id')->unsigned()->nullable();
            //User that posted this comment
            $table->integer('author_id')->unsigned()->nullable();
            //Content of comment
            $table->mediumText('body');
            //Generate timestamps for update and creation
            $table->timestamps();
            $table->softDeletes();
        });

    Schema::table('comments', function (Blueprint $table) {
        $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
        $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
