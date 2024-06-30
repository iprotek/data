<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDataValue2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $table_name = 'data_model_field_values';
    
        if(Schema::hasTable($table_name)) {

            // TARGET NAME
                Schema::table( $table_name, function (Blueprint $table) use($table_name) { 
                    if (!Schema::hasColumn($table_name, 'ref_id'))
                    $table->bigInteger('ref_id')->nullable();
                    if (!Schema::hasColumn($table_name, 'ref_source'))
                    $table->string('ref_source')->nullable();
                });
            return;
        }
        //Schema::create('data', function (Blueprint $table) {
        Schema::table('data', function (Blueprint $table) { 
            $table->bigInteger('ref_id')->nullable();
            $table->string('ref_source')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
