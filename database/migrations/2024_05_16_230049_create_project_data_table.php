<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_name = 'data';
    
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
                    if (!Schema::hasColumn($table_name, 'data_model_id'))
                    $table->integer('data_model_id')->nullable(); 
                    if (!Schema::hasColumn($table_name, 'data_model_type'))
                    $table->string('data_model_type')->nullable(); 
                    if (!Schema::hasColumn($table_name, 'address'))
                    $table->text('address')->nullable();
                    if (!Schema::hasColumn($table_name, 'business_type'))
                    $table->string('business_type')->nullable();
                    if (!Schema::hasColumn($table_name, 'status'))
                    $table->string('status')->nullable();
                    if (!Schema::hasColumn($table_name, 'deleted_at'))
                    $table->softDeletes();
                });
            return;
        }
        Schema::create('data', function (Blueprint $table) {
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
            $table->integer('data_model_id')->nullable(); 
            $table->string('data_model_type')->nullable(); 
            $table->text('address')->nullable();
            $table->string('business_type')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('project_data');
    }
}
