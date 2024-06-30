<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        $table_name = 'data_models';
    
        if(Schema::hasTable($table_name)) {

            // TARGET NAME
                Schema::table( $table_name, function (Blueprint $table) use($table_name) {
                    if (!Schema::hasColumn($table_name, 'details'))
                        $table->longText('details')->nullable(); 
                    if (!Schema::hasColumn($table_name, 'json_info'))
                        $table->longText('json_info')->nullable(); 
                    if (!Schema::hasColumn($table_name, 'from'))
                        $table->date('from')->nullable();
                    if (!Schema::hasColumn($table_name, 'to'))
                        $table->date('to')->nullable();
                    if (!Schema::hasColumn($table_name, 'type'))
                        $table->string('type');
                    if (!Schema::hasColumn($table_name, 'address'))
                        $table->text('address')->nullable();
                    if (!Schema::hasColumn($table_name, 'business_type'))
                        $table->string('business_type')->nullable();
                    if (!Schema::hasColumn($table_name, 'status'))
                        $table->string('status')->nullable();
                });
            return;
        }



        Schema::create( $table_name, function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->bigInteger('group_id')->nullable();
            $table->bigInteger('pay_created_by')->nullable(); 
            $table->bigInteger('pay_updated_by')->nullable();
            $table->bigInteger('pay_deleted_by')->nullable();

            $table->longText('details')->nullable();
            $table->longText('json_info')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->string('type');
            $table->text('address')->nullable();
            $table->string('business_type')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('data_models');
    }
}
