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
        Schema::create('medical_referral', function (Blueprint $table) {
            $table->id('mr_id');
            $table->date('mr_date');
            $table->string('mr_patient_name');
            $table->integer('mr_age');
            $table->string('mr_sex');
            $table->integer('dept_id');
            $table->integer('prog_id');
            $table->string('mr_to');
            $table->text('mr_evaluation_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_referral');
    }
};
