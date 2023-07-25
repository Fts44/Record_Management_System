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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id('acc_id');
            $table->boolean('acc_is_blocked')->default(0);
            $table->boolean('acc_is_verified');
            $table->boolean('acc_email_verified')->default(0);
            $table->string('acc_password');
            $table->dateTime('acc_created_date')->default(DB::raw('CURRENT_TIMESTAMP'));           
            $table->dateTime('acc_last_login')->nullable();
            $table->string('acc_token');
            $table->date('acc_token_last_send')->nullable();
            $table->dateTime('acc_token_expr')->nullable();
            $table->dateTime('acc_info_last_update')->nullable();
            $table->string('acc_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
