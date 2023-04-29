<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Notes: 项目数据初始化模块
 *
 * Class CreateInitTable
 */
class CreateInitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('init_record', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment('type');
            $table->boolean('is_init')->comment('is_init');
            $table->string('remark')->comment('remark');
            $table->text('record')->comment('record');
            $table->timestamps();

            $table->unique('type', 'init_record_type_unique');
        });
        DB::statement("ALTER TABLE init_record COMMENT='init_record'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('init_record');
    }
}
