<?php

use Illuminate\Support\Facades\Schema;
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
        Schema::create('users', function (Blueprint $table) {
             $table->increments('id');
            $table->string('fname');
            $table->string('lname');
            $table->date('bdate');
            $table->string('nname')->nullable();
            $table->string('pnumber')->nullable()->unique();
            $table->boolean('gender');
            $table->string('hometown')->nullable();
            $table->string('aboutme')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
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
