<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataModelFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'data_model_fields';
    
        if(Schema::hasTable($table_name)) {

            // TARGET NAME
                Schema::table( $table_name, function (Blueprint $table) use($table_name) {
                    if (!Schema::hasColumn($table_name, 'data_model_id'))
                    $table->integer('data_model_id')->nullable();
                    if (!Schema::hasColumn($table_name, 'model_field_id'))
                    $table->integer('model_field_id')->nullable();
                    if (!Schema::hasColumn($table_name, 'parent_id'))
                    $table->integer('parent_id')->nullable(); 
                    //$table->integer('type')->nullable(); 
                    if (!Schema::hasColumn($table_name, 'order_id'))
                    $table->integer('order_id')->nullable();
                });
            return;
        }

        Schema::create('data_model_fields', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('group_id')->nullable();
            $table->bigInteger('pay_created_by')->nullable(); 
            $table->bigInteger('pay_updated_by')->nullable();
            $table->bigInteger('pay_deleted_by')->nullable();

            $table->integer('data_model_id');
            $table->integer('model_field_id');
            $table->integer('parent_id')->nullable(); 
            //$table->integer('type')->nullable(); 
            $table->integer('order_id')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_model_fields');
    }
}
