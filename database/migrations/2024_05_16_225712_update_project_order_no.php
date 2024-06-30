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
        
        $table_name = 'data_model_field_values';
    
        if(Schema::hasTable($table_name)) {

            // TARGET NAME
                Schema::table( $table_name, function (Blueprint $table) use($table_name) {
                    if (!Schema::hasColumn($table_name, 'order_no'))
                    $table->integer('order_no')->nullable();  
                    if (!Schema::hasColumn($table_name, 'project_data_id'))
                    $table->integer('project_data_id')->nullable();  
                });
            //return;
        }
        else
        {
            Schema::table('data_model_field_values', function (Blueprint $table) { 
                $table->integer('order_no')->nullable();  
                $table->integer('project_data_id')->nullable();  
            });
        }


        $table_name = 'data_model_fields';
    
        if(Schema::hasTable($table_name)) { 
            // TARGET NAME
                Schema::table( $table_name, function (Blueprint $table) use($table_name) {
                    if (!Schema::hasColumn($table_name, 'order_no'))
                    $table->integer('order_no')->nullable();  
                });
            //return;
        }
        else{
            Schema::table('data_model_fields', function (Blueprint $table) { 
                $table->integer('order_no')->nullable();  
            });
        }
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
