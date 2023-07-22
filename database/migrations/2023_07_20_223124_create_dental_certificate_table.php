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
        Schema::create('dental_certificate', function (Blueprint $table) {
            $table->id('dc_id');
            $table->date('dc_date');
            $table->string('dc_patient_name');
            $table->integer('dc_age');
            $table->string('dc_sex');
            $table->string('dc_civil_status');
            $table->string('dc_address');
            $table->text('dc_diagnosis_treatment');
            $table->text('dc_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dental_certificate');
    }
};
