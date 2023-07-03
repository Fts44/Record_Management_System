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
        Schema::create('medical_request_slip', function (Blueprint $table) {
            $table->id('mrs_id');
            $table->string('mrs_patient_name');
            $table->date('mrs_date');
            $table->integer('mrs_age');
            $table->string('mrs_sex');
            $table->string('mrs_requested_by');
            $table->boolean('mrs_chest_xray')->default(0);
            $table->boolean('mrs_cbc')->default(0);
            $table->boolean('mrs_urinalysis')->default(0);
            $table->boolean('mrs_fecalysis')->default(0);
            $table->boolean('mrs_drug_test')->default(0);
            $table->boolean('mrs_blood_typing')->default(0);
            $table->string('mrs_others')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_request_slip');
    }
};
