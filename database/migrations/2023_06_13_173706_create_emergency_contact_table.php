<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_contact', function (Blueprint $table) {
            $table->id('ec_id');
            $table->string('ec_firstname');
            $table->string('ec_middlename')->nullable();;
            $table->string('ec_lastname');
            $table->string('ec_contact_no')->nullable();
            $table->string('ec_telephone_no')->nullable();
            $table->string('ec_relationship')->nullable();
            $table->integer('add_id')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergency_contact');
    }
};
