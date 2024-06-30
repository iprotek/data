<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'model_fields';
    
        if(Schema::hasTable($table_name)) {

            // TARGET NAME
                Schema::table( $table_name, function (Blueprint $table) use($table_name) {
                    if (!Schema::hasColumn($table_name, 'details'))
                        $table->longText('details')->nullable();
                    if (!Schema::hasColumn($table_name, 'data_type'))
                        $table->string('data_type')->nullable(); // project, person, company, painter
                    if (!Schema::hasColumn($table_name, 'json_info'))
                        $table->longText('json_info')->nullable();
                    if (!Schema::hasColumn($table_name, 'has_date'))
                        $table->boolean('has_date')->nullable();
                    if (!Schema::hasColumn($table_name, 'from'))
                        $table->date('from')->nullable();
                    if (!Schema::hasColumn($table_name, 'to'))
                        $table->date('to')->nullable();
                    if (!Schema::hasColumn($table_name, 'order_id'))
                        $table->integer('order_id')->nullable();
                });
            return;
        }

        Schema::create('model_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->bigInteger('group_id')->nullable();
            $table->bigInteger('pay_created_by')->nullable(); 
            $table->bigInteger('pay_updated_by')->nullable();
            $table->bigInteger('pay_deleted_by')->nullable();

            $table->longText('details')->nullable();
            $table->string('data_type')->nullable(); // project, person, company, painter
            $table->longText('json_info')->nullable();
            $table->boolean('has_date')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
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
        Schema::dropIfExists('model_fields');
    }
}
