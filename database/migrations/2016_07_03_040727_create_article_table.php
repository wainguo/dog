<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('user_name', 32);
            $table->integer('channel_id');
            $table->integer('mall_id');
            $table->string('title', 255);
            $table->string('subtitle', 64);
            $table->longText('content');
            $table->string('excerpt', 255);
            $table->string('cover', 255);
            $table->string('url', 2048)->nullable();
            $table->string('type', 16);
            $table->string('block', 16)->nullable();
            $table->string('status', 20)->default('publish');
            $table->string('comment_status', 20)->default('open');
            $table->integer('comment_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->string('slug',255)->index();
            $table->timestamps();

//            $table->foreign('author')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
