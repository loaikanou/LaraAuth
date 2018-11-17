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
            $table->string('name');
            $table->string('username')->nullable(); //->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default('avatar.png');
            $table->boolean('active')->default(false)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('activation_token')->nullable();
            $table->rememberToken();
            $table->longText('api_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
