<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique();
            $table->string('password')->unique();
            $table->string('full_name')->default('Anonym');
            $table->string('email')->unique();
            $table->string('profile_picture')->default('storage\app\public\user_avatar.png');//?
            $table->integer('rating')->default(0);
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->timestamps();

            // // $table->timestamp('email_verified_at')->nullable();
            // // $table->string('password');
            // // $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
