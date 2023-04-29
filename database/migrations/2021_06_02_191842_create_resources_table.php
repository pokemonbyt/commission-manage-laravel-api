<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model_type')->nullable()->comment('model_type');
            $table->string('model_id')->nullable()->comment('model_id');
            $table->string('name')->comment('name');
            $table->string('path')->comment('path');
            $table->string('extension')->comment('extension');
            $table->string('mine_type')->comment('mine_type');
            $table->string('size')->comment('size');
            $table->string('md5')->comment('md5');
            $table->timestamps();

            $table->index(['model_type', 'model_id'], 'resources_model_type_model_id_index');
            $table->index('md5', 'resources_md5_index');
        });
        DB::statement("ALTER TABLE resources COMMENT='resources'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
