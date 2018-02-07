<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            // Each post is identified with an ID
            $table->increments('id');
            // Each post must have an author when created. If the author's account is deleted, the field is set to null
            // and the UI should display the author as "deleted user"
            $table->integer('author_id')->unsigned()->nullable();
            // A post can have a parent post. If the post has a parent, it is either a comment or answer
            $table->integer('parent_id')->unsigned()->nullable();
            // If the post has a parent, and isComment is set to TRUE (or 1) then the post is a comment
            $table->boolean('isComment')->nullable();
            // Each post can have a title
            $table->text('title');
            // The content of the post:
            $table->multiLineString('content');
            // Generate timestamps for update and creation
            $table->timestamps();


            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null')->onUpdate('no action');
            $table->foreign('parent_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
