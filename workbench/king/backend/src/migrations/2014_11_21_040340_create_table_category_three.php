<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCategoryThree extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_three', function($table){
            $table->increments('id');
            $table->integer('category_root_id');
            $table->integer('category_one_id');
            $table->integer('category_two_id');
            $table->string('name');
            $table->string('image');
            $table->string('description');
            $table->boolean('is_active');
            $table->integer('order_number');
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
        Schema::drop('category_three');
    }

}
