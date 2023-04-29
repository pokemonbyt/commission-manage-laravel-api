<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateAnotherTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_details', function (Blueprint $table) {
            $table->bigIncrements('id')->comment("id");
            $table->string('agency', 40)->comment("dai ly");
            $table->string('player_username', 40)->comment("Tai khoan hoi vien");
            $table->string('full_name', 50)->comment("Ho ten");
            $table->string('phone', 15)->comment("So dien thoai");
            $table->string('month', 10)->comment("Thang");
            $table->string('logout_days', 10)->comment("So ngay khong dang nhap");
            $table->string('total_money', 30)->comment("Tong tien thang thua");
            $table->timestamps();

            $table->index('agency','agency_details_agency_index');
            $table->index('month','agency_details_month_index');
            $table->index('player_username','agency_details_player_username_index');
        });
        DB::statement("ALTER TABLE agency_details COMMENT='agency_details'");

        Schema::create('agency_manager', function (Blueprint $table) {
            $table->bigIncrements('id')->comment("id");
            $table->string('agency', 40)->comment("dai ly");
            $table->string('level1', 10)->comment("Muc 1");
            $table->string('level2', 10)->comment("Muc 2");
            $table->string('level3', 10)->comment("Muc 3");
            $table->string('level4', 10)->comment("Muc 4");

            $table->timestamps();

            $table->index('agency','agency_manager_agency_index');
        });
        DB::statement("ALTER TABLE agency_manager COMMENT='agency_manager'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency_details');
    }
}
