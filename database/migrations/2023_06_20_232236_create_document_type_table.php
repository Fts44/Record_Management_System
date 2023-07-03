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
        Schema::create('document_type', function (Blueprint $table) {
            $table->id('dt_id');
            $table->string('dt_display_name');
            $table->string('dt_table_name');
        });

        DB::table('document_type')->insert([
            [
                'dt_display_name' => 'medical certificate', 
                'dt_table_name' => 'er_med_cert' 
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_type');
    }
};
