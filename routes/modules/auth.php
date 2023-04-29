<?php
/**
 * 认证模块
 */
Route::namespace('Auth')->group(function () {
    Route::get('auth/info', 'AuthController@info')->name("auth.info");

    Route::post('auth/logout', 'AuthController@logout')->name("auth.logout");
});
