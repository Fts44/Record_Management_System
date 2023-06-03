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
        Schema::create('ref_religion', function (Blueprint $table) {
            $table->id('rlgn_id');
            $table->string('rlgn_name');
        });

        DB::table('ref_religion')->insert([
                
            [
                'rlgn_id' => '1',
                'rlgn_name' => 'Others'
            ],
            [
                'rlgn_id' => '2',
                'rlgn_name' => 'Aglipay'
            ],
            [
                'rlgn_id' => '3',
                'rlgn_name' => 'Association of Baptist Churches in Luzon, Visayas and Mindanao'
            ],
            [
                'rlgn_id' => '4',
                'rlgn_name' => 'Association of Fundamental Baptist Church in the Philippines'
            ],
            [
                'rlgn_id' => '5',
                'rlgn_name' => 'Bible Baptist'
            ],
            [
                'rlgn_id' => '6',
                'rlgn_name' => 'Buddhist'
            ],
            [
                'rlgn_id' => '7',
                'rlgn_name' => 'Convention of the Philippine Baptist Church'
            ],
            [
                'rlgn_id' => '8',
                'rlgn_name' => 'Episcopal'
            ],
            [
                'rlgn_id' => '9',
                'rlgn_name' => 'Evangelical'
            ],
            [
                'rlgn_id' => '10',
                'rlgn_name' => 'Iglesia Evangelista Methodista en Las Filipinas'
            ],
            [
                'rlgn_id' => '11',
                'rlgn_name' => 'Iglesia ni Cristo'
            ],
            [
                'rlgn_id' => '12',
                'rlgn_name' => 'International Baptist Missionary Fellowship'
            ],
            [
                'rlgn_id' => '13',
                'rlgn_name' => 'Islam '
            ],
            [
                'rlgn_id' => '14',
                'rlgn_name' => 'Jehovah Witness'
            ],
            [
                'rlgn_id' => '15',
                'rlgn_name' => 'Latter Day Saints'
            ],
            [
                'rlgn_id' => '16',
                'rlgn_name' => 'Lutheran'
            ],
            [
                'rlgn_id' => '17',
                'rlgn_name' => 'Missionary Baptist Churches of the Philippines'
            ],
            [
                'rlgn_id' => '18',
                'rlgn_name' => 'Philippine Benevolent Missionaries Association'
            ],
            [
                'rlgn_id' => '19',
                'rlgn_name' => 'Roman Catholic'
            ],
            [
                'rlgn_id' => '20',
                'rlgn_name' => 'Salvation Army'
            ],
            [
                'rlgn_id' => '21',
                'rlgn_name' => 'Seventh Day Adventist'
            ],
            [
                'rlgn_id' => '22',
                'rlgn_name' => 'Southern Baptist'
            ],
            [
                'rlgn_id' => '23',
                'rlgn_name' => 'Tribal'
            ],
            [
                'rlgn_id' => '24',
                'rlgn_name' => 'United Church of Christ'
            ],
            [
                'rlgn_id' => '25',
                'rlgn_name' => 'United Methodist Church'
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
        Schema::dropIfExists('ref_religion');
    }
};
