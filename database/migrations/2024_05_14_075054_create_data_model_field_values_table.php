<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataModelFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_model_field_values', function (Blueprint $table) {
            $table->id();

            $table->integer('order_id')->nullable();
            $table->bigInteger('group_id')->nullable();
            $table->bigInteger('pay_created_by')->nullable(); 
            $table->bigInteger('pay_updated_by')->nullable();
            $table->bigInteger('pay_deleted_by')->nullable();

            $table->integer('parent_id')->nullable();
            $table->integer('data_model_id')->nullable();
            $table->integer('model_field_id')->nullable();
            $table->integer('data_model_field_id')->nullable(); 

            $table->string('type'); //field, data_model, text, description
            $table->integer('value_target'); //1,2,3
            $table->string('value1')->nullable();
            $table->longText('value2')->nullable();
            $table->integer('value3')->nullable();

            
            $table->boolean('has_date')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->string('data_type'); //field, person, project, company, painter, contact

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
        Schema::dropIfExists('data_model_field_values');
    }
}
