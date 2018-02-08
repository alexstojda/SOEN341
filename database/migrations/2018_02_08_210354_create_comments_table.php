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
            $table->increments('id');
            //Question that this comment is related to or null
            $table->integer('question_id')->unsigned()->nullable();
            //Answer that this comment is related to or null
            $table->integer('answer_id')->unsigned()->nullable();
            //User that posted this comment
            $table->integer('user_id')->unsigned();
            //Content of comment
            $table->multiLineString('comment_body');
            // Generate timestamps for update and creation
            $table->timestamps('created_at');


           // $table->foreign('user_id','question_id','answer_id')->references('id')->on('users')->onDelete('set null')->onUpdate('no action');
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
