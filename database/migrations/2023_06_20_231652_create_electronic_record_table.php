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
        Schema::create('electronic_record', function (Blueprint $table) {
            $table->id('er_id');
            $table->datetime('er_created_date');
            $table->datetime('er_doc_last_update')->nullable();
            $table->integer('er_doc_org_id');  // original id base on their respective table
            $table->string('er_control_no')->nullable(); // for documents needed customize control no
            $table->integer('dt_id');
            $table->integer('physician_id');
            $table->integer('patient_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('electronic_record');
    }
};
