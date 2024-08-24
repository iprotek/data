<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentMetaDataTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_meta_data_tracks', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('group_id')->nullable(); 
            $table->bigInteger('pay_created_by')->nullable(); 
            $table->bigInteger('pay_updated_by')->nullable();
            $table->bigInteger('pay_deleted_by')->nullable();
            $table->softDeletes(); 
            $table->timestamps();

            $table->integer('content_meta_data_id');
            $table->bigInteger('user_admin_id')->nullable(); 
            $table->string('link_source_name')->nullable(); //google, facebook, twitter
            $table->text('link_ref')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_meta_data_tracks');
    }
}
