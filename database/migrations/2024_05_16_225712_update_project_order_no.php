<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectOrderNo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('data_model_field_values', function (Blueprint $table) { 
            $table->integer('order_no')->nullable();  
            $table->integer('project_data_id')->nullable();  
        });
        Schema::table('data_model_fields', function (Blueprint $table) { 
            $table->integer('order_no')->nullable();  
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
