<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateRevisionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisions', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id')->comment("id");
            $table->string('revisionable_type')->comment("revisionable_type");
            $table->integer('revisionable_id')->comment("revisionable_id");
            $table->integer('user_id')->nullable()->comment("user_id");
            $table->string('key')->comment("key");
            $table->text('old_value')->nullable()->comment("old_value");
            $table->text('new_value')->nullable()->comment("new_value");
            $table->timestamps();

            $table->index(array('revisionable_id', 'revisionable_type'));
        });
        DB::statement("ALTER TABLE revisions COMMENT='revisions'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revisions');
    }
}
