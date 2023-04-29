<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateSaveDeleteRecordTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_delete_record', function (Blueprint $table) {
            $table->bigIncrements('id')->comment("id");
            $table->string('recordable_type')->comment("recordable_type");
            $table->bigInteger('recordable_id')->comment("recordable_id");
            $table->integer('user_id')->comment("user_id");
            $table->string('operate')->comment("operate");
            $table->string('username', 20)->nullable()->comment("username");
            $table->string('name')->nullable()->comment("name");
            $table->json('record')->nullable()->comment("record");
            $table->timestamps();

            $table->index(['recordable_type', 'recordable_id'], 'save_delete_record_recordable_type_recordable_id_index');
        });
        DB::statement("ALTER TABLE save_delete_record COMMENT='save_delete_record'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_delete_record');
    }
}
