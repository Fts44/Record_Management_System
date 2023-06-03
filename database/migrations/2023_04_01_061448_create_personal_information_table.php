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
        Schema::create('personal_information', function (Blueprint $table) {
            $table->id('pi_id');
            $table->integer('acc_id')->unique();
            $table->integer('add_id')->unique()->nullable();
            $table->integer('rlgn_id')->nullable();
            $table->string('pi_classification');
            $table->string('pi_position')->nullable();
            $table->string('pi_firstname')->nullable();
            $table->string('pi_middlename')->nullable();
            $table->string('pi_lastname')->nullable();
            $table->string('pi_sex')->nullable();
            $table->date('pi_birthdate')->nullable();
            $table->string('pi_civil_status')->nullable();
            $table->string('pi_grade_level')->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('crs_id')->nullable();
            // $table->integer('pi_year_level')->nullable();
            $table->string('pi_gsuite_email')->unique()->nullable();
            $table->string('pi_personal_email')->unique()->nullable();
            $table->string('pi_contact_no')->unique()->nullable();
            $table->string('pi_srcode')->unique()->nullable();
            $table->string('pi_photo')->nullable();
            $table->integer('ttl_id')->nullable();
            $table->string('pi_signature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_information');
    }
};
