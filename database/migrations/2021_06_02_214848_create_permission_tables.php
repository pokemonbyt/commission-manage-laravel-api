<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Notes: 权限模块
 *
 * Class CreatePermissionTables
 */
class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id');
            $table->string('name')->comment('名字');
            $table->string('guard_name')->comment('路由守卫');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE permissions COMMENT='权限模块-权限表'");

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id');
            $table->string('name')->comment('名字');
            $table->string('guard_name')->comment('路由守卫');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE roles COMMENT='权限模块-角色表'");

        Schema::create('routes', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id');
            $table->string('name')->comment('名字');
            $table->string('url')->comment('路由路径');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE routes COMMENT='权限模块-路由表'");

        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id');
            $table->string('name')->comment('组件名字');
            $table->string('path')->comment('路由路径');
            $table->string('component')->nullable()->comment('组件');
            $table->string('redirect')->nullable()->comment('重定向路径');
            $table->string('title')->nullable()->comment('标题(决定前端翻译用的key)');
            $table->string('icon')->nullable()->comment('图标');
            $table->tinyInteger('hidden')->comment('是否在侧边栏隐藏');
            $table->tinyInteger('no_cache')->comment('是否被缓存');
            $table->tinyInteger('outreach')->comment('是否可以跳转外部连接');
            $table->integer('sort')->comment('排序');
            $table->bigInteger('pid')->comment('父级id');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE menus COMMENT='权限模块-前端菜单表'");

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id')->comment("权限id");

            $table->string('model_type')->comment("模型类型");
            $table->unsignedBigInteger($columnNames['model_morph_key'])->comment("用户id");
            $table->index([$columnNames['model_morph_key'], 'model_type', ], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
        });
        DB::statement("ALTER TABLE model_has_permissions COMMENT='权限模块-用户拥有的权限表'");

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id')->comment("角色id");

            $table->string('model_type')->comment("模型类型");
            $table->unsignedBigInteger($columnNames['model_morph_key'])->comment("用户id");
            $table->index([$columnNames['model_morph_key'], 'model_type', ], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });
        DB::statement("ALTER TABLE model_has_roles COMMENT='权限模块-用户拥有的角色表'");

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id')->comment("权限id");
            $table->unsignedBigInteger('role_id')->comment("角色id");

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });
        DB::statement("ALTER TABLE role_has_permissions COMMENT='权限模块-角色拥有的权限表'");

        Schema::create('permission_has_routes', function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('router_id')->comment("路由id");
            $table->unsignedBigInteger('permission_id')->comment("权限id");

            $table->foreign('router_id')
                ->references('id')
                ->on('routes')
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['router_id', 'permission_id'], 'permission_has_routes_router_id_permission_id_primary');
        });
        DB::statement("ALTER TABLE permission_has_routes COMMENT='权限模块-权限拥有的路由表'");

        Schema::create('permission_has_menus', function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('menu_id')->comment("菜单id");
            $table->unsignedBigInteger('permission_id')->comment("权限id");

            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['menu_id', 'permission_id'], 'permission_has_menus_menu_id_permission_id_primary');
        });
        DB::statement("ALTER TABLE permission_has_menus COMMENT='权限模块-权限拥有的菜单表'");

        Schema::create('permission_or_role_info', function (Blueprint $table) use ($tableNames) {
            $table->bigIncrements('id')->comment('id');
            $table->bigInteger('model_id')->comment('模型id');
            $table->tinyInteger('model_type')->comment('模型类型');
            $table->string('name', 100)->nullable()->comment('名字');
            $table->string('description', 255)->nullable()->comment('描述');
            $table->tinyInteger('status')->default(1)->comment('是否可以授权状态');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE permission_or_role_info COMMENT='权限模块-权限或者角色描述信息表'");

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop('permission_has_routes');
        Schema::drop('permission_has_menus');

        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
        Schema::drop('routes');
        Schema::drop('menus');
        Schema::drop('permission_or_role_info');
    }
}
