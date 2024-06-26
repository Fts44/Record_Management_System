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
        });

        DB::table('document_type')->insert([
            [
                'dt_id' => 1,
                'dt_display_name' => 'medical request slip'
            ],
            [
                'dt_id' => 2,
                'dt_display_name' => 'dental certificate'
            ],
            [
                'dt_id' => 3,
                'dt_display_name' => 'excuse slip'
            ],
            [
                'dt_id' => 4,
                'dt_display_name' => 'medical certificate'
            ],
            [
                'dt_id' => 5,
                'dt_display_name' => 'medical referral'
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
