<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('office_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('locality');
            $table->string('address');
            $table->string('city')->index();
            $table->unsignedInteger('state_id');
            $table->unsignedInteger('country_id');
            $table->string('landmark')->nullable();
            $table->string('zip_code', 10);
            $table->enum('type', ['SHIPPING', 'BILLING'])->default('SHIPPING');
            $table->tinyInteger('default')->default(0)->index();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');

            $table->foreign('state_id')
                ->references('id')->on('states')
                ->onDelete('CASCADE');

            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['state_id']);
            $table->dropForeign(['country_id']);
        });
        Schema::dropIfExists('addresses');
    }
}
