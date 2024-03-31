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
        Schema::create('excuse_slip', function (Blueprint $table) {
            $table->id('es_id');
            $table->date('es_date');
            $table->string('es_patient_name');
            $table->integer('es_age');
            $table->integer('dept_id');
            $table->integer('prog_id');
            $table->string('es_authorized_by');
            $table->text('es_complaints');
            $table->text('es_diagnosis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excuse_slip');
    }
};
