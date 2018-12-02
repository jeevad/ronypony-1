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
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('mobile_number', 20)->index()->nullable();
            $table->string('email_activation_token')->nullable();
            $table->timestamp('email_activation_token_sent_at')->nullable();
            $table->boolean('email_verified')->default(false)->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('sign_up_ip', 30)->nullable();
            $table->string('sign_up_user_agent')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('banned')->default(false);
            $table->timestamp('banned_at')->nullable();
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
