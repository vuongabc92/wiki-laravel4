<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function($table){
            $table->increments('id');
            $table->string('username', 32);
            $table->string('email', 100);
            $table->string('password', 128);
            $table->string('role', 16);
            $table->boolean('is_active');
            $table->string('remember_token', 100);//Should has nullable attribute
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
        Schema::dropIfExists('users');
    }

}
