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
            $table->string('last_name')->nullable();
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('mobile_number', 20);
            $table->string('locality');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('landmark')->nullable();
            $table->string('zip_code', 15);
            $table->enum('address_type', ['SHIPPING/BILLING']);

            $table->foreign('user_id')
                ->references('id')->on('users')
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
        });
        Schema::dropIfExists('addresses');
    }
}
