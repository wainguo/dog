<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlemetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articlemetas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->index();
            $table->string('meta_key', 100)->index();
            $table->string('meta_value', 255);
            $table->timestamps();

//            $table->foreign('article_id')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articlemetas');
    }
}
