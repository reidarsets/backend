<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('author')->unsigned();
            $table->foreign('author')->references('id')->on('users')->cascadeOnDelete();
            $table->BigInteger('post_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->BigInteger('comment_id')->unsigned();
            $table->foreign('comment_id')->references('id')->on('comments')->cascadeOnDelete();
            $table->enum('type', ['like', 'dislike']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
