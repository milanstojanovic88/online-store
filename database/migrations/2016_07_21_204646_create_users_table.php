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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
	        $table->string('email')->unique()->nullable();
	        $table->string('password');
	        $table->string('name');
	        $table->string('avatar')->default('default.jpg');
	        $table->boolean('verified')->default(false);
	        $table->string('confirmation_code')->nullable();
	        $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
