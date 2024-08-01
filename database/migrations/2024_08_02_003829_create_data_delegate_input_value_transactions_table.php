<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataDelegateInputValueTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_delegate_input_value_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('data_delegate_input_value_id');
            $table->string('from_val', 500);
            $table->string('to_val', 500);
            $table->integer('updated_by');
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
        Schema::dropIfExists('data_delegate_input_value_transactions');
    }
}
