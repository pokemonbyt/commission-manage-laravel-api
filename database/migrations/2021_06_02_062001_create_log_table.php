<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('type');
            $table->text('model_type')->comment('model_type');
            $table->bigInteger('model_id')->comment('model_id');
            $table->bigInteger('user_id')->nullable()->comment('user_id');
            $table->text('body')->nullable()->comment('body');
            $table->string('remark')->nullable()->comment('remark');
            $table->timestamps();

            $table->index('type','log_table_type_index');
        });
        DB::statement("ALTER TABLE log COMMENT='log'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log');
    }
}
