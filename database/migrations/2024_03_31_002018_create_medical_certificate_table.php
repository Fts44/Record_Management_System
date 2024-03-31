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
        Schema::create('medical_certificate', function (Blueprint $table) {
            $table->id('mc_id');
            $table->date('mc_date');
            $table->string('mc_patient_name');
            $table->integer('mc_age');
            $table->string('mc_sex');
            $table->string('mc_civil_status');
            $table->date('mc_date_examined');
            $table->string('mc_address');
            $table->text('mc_diagnosis');
            $table->text('mc_remarks');
            $table->string('mc_purpose');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_certificate');
    }
};
