<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectDataValue extends Migration
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
                    if (!Schema::hasColumn($table_name, 'deleted_at'))
                    $table->softDeletes();
                });
            return;
        }

        Schema::table('data_model_field_values', function (Blueprint $table) { 
            $table->softDeletes();  
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
