<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_one_id');
            $table->unsignedInteger('user_two_id');
            $table->tinyInteger('status')->deafult(\App\Friendship::PENDDING);
            $table->unsignedInteger('user_last_action_id');
            $table->foreign('user_one_id')->references('id')->on('users');
            $table->foreign('user_two_id')->references('id')->on('users');
            $table->foreign('user_last_action_id')->references('id')->on('users');
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
        Schema::dropIfExists('friendships');
    }
}
