<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('author')->unsigned();
            $table->foreign('author')->references('id')->on('users')->cascadeOnDelete();
            $table->string('title');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('content');
            $table->string('categories')->default('[]');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
