<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('profile_realname', 16);
            $table->string('profile_phone', 16);
            $table->string('profile_address', 255);
            $table->string('profile_postcode', 16);
            $table->string('profile_introduction', 255);
            $table->integer('article_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->integer('favor_count')->default(0);
            $table->integer('coin_count')->default(0);
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
        Schema::drop('profile');
    }
}
