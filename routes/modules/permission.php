<?php
/**
 * 权限模块
 */
Route::namespace('Permission')->group(function () {
    Route::post('permission/create', 'PermissionController@create')->name("permission.create");

    Route::post('permission/delete', 'PermissionController@delete')->name("permission.delete");

    Route::post('permission/edit', 'PermissionController@edit')->name("permission.edit");

    Route::get('permission/all', 'PermissionController@all')->name("permission.all");

    Route::post('permission/give-to-user', 'PermissionController@giveToUser')->name("permission.giveToUser");

    Route::post('permission/revoke-to-user', 'PermissionController@revokeToUser')->name("permission.revokeToUser");

    Route::post('permission/sync-to-user', 'PermissionController@syncToUser')->name("permission.syncToUser");

    Route::get('permission/has-to-user', 'PermissionController@hasToUser')->name("permission.hasToUser");

    Route::get('permission/find-in-users', 'PermissionController@findInUsers')->name("permission.findInUsers");

    Route::get('permission/find-all-to-user', 'PermissionController@findAllToUser')->name("permission.findAllToUser");

    Route::get('permission/find-all-to-me', 'PermissionController@findAllToMe')->name("permission.findAllToMe");

    Route::get('permission/roles-by-permission', 'PermissionController@rolesByPermission')->name("permission.rolesByPermission");
});

/**
 * 角色模块
 */
Route::namespace('Permission')->group(function () {
    Route::post('role/create', 'RoleController@create')->name("role.create");

    Route::post('role/delete', 'RoleController@delete')->name("role.delete");

    Route::post('role/edit', 'RoleController@edit')->name("role.edit");

    Route::get('role/all', 'RoleController@all')->name("role.all");

    Route::post('role/assign-to-user', 'RoleController@assignToUser')->name("role.assignToUser");

    Route::post('role/give-permission-to', 'RoleController@givePermissionTo')->name("role.givePermissionTo");

    Route::post('role/remove-to-user', 'RoleController@removeToUser')->name("role.removeToUser");

    Route::post('role/revoke-permission-to', 'RoleController@revokePermissionTo')->name("role.revokePermissionTo");

    Route::get('role/find-permission-to', 'RoleController@findPermissionTo')->name("role.findPermissionTo");

    Route::post('role/sync-to-user', 'RoleController@syncToUser')->name("role.syncToUser");

    Route::get('role/has-to-user', 'RoleController@hasToUser')->name("role.hasToUser");

    Route::get('role/find-in-user', 'RoleController@findInUser')->name("role.findInUser");

    Route::get('role/find-all-to-user', 'RoleController@findAllToUser')->name("role.findAllToUser");

    Route::get('role/user-role-permission', 'RoleController@findPermissionAndRoleByUsername')->name("role.findPermissionAndRoleByUsername");

    Route::get('role/my-role-permission', 'RoleController@findMyPermissionAndRole')->name("role.findMyPermissionAndRole");

    Route::get('role/compare-to-user', 'RoleController@compareToUser')->name("role.compareToUser");

    Route::get('role/find-my-employees', 'RoleController@findMyEmployees')->name("role.findMyEmployees");
});

/**
 * 路由模块
 */
Route::namespace('Permission')->group(function () {
    Route::post('router/create', 'RouterController@create')->name("router.create");

    Route::post('router/delete', 'RouterController@delete')->name("router.delete");

    Route::get('router/all', 'RouterController@all')->name("router.all");

    Route::post('router/add-to-permission', 'RouterController@addToPermission')->name("router.addToPermission");

    Route::post('router/remove-to-permission', 'RouterController@removeToPermission')->name("router.removeToPermission");

    Route::get('router/find-to-permission', 'RouterController@findToPermission')->name("router.findToPermission");
});

/**
 * 菜单模块
 */
Route::namespace('Permission')->group(function () {
    Route::post('menu/create', 'MenuController@create')->name("menu.create");

    Route::post('menu/delete', 'MenuController@delete')->name("menu.delete");

    Route::post('menu/edit', 'MenuController@edit')->name("menu.edit");

    Route::get('menu/all', 'MenuController@all')->name("menu.all");

    Route::post('menu/add-to-permission', 'MenuController@addToPermission')->name("menu.addToPermission");

    Route::post('menu/remove-to-permission', 'MenuController@removeToPermission')->name("menu.removeToPermission");

    Route::get('menu/find-to-permission', 'MenuController@findToPermission')->name("menu.findToPermission");

    Route::get('menu/find-all-to-user', 'MenuController@findAllToUser')->name("menu.findAllToUser");
});
