<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question', function (Blueprint $table) {
            $table->increments('id');
            //Question identifier
            $table->increments('question_id');
            //User that posted this question
            $table->integer('user_id')->unsigned();
            //Question's main title
            $table->text('question_head');
            //Question content
            $table->multiLineString('question_body');
            // Generate timestamps for update and creation
            $table->timestamps('created_at');


            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question');
    }
}
