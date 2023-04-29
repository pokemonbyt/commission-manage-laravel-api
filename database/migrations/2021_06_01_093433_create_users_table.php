<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Notes: 用户模块
 *
 * Class CreateUsersTable
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment("id");
            $table->bigInteger('pid')->comment("pid");
            $table->string('username', 40)->comment("username");
            $table->string('name', 255)->comment("name");
            $table->string('password', 255)->comment("mat khau");
            $table->tinyInteger('types')->comment("types: 1:THLV 2:HLV 3:TT 4:MKT 5:KH");
            $table->tinyInteger('is_active')->comment("is active");
            $table->string('privacy_password', 255)->nullable()->comment("mat khau cap 2");
            $table->timestamps();

            $table->index('username','users_username_index');
            $table->index('pid','users_pid_index');
            $table->index('name','users_name_index');
            $table->index(['username', 'name'], 'users_username_name_index');
            $table->unique('username','users_username_unique');
        });
        DB::statement("ALTER TABLE users COMMENT='users'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
