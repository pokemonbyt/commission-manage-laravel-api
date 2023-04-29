<?php
/**
 * 网址模块
 */
Route::namespace('AgencyManager')->group(function () {
    Route::post('account/create', 'AccountController@create')->name("account.create");

    Route::post('account/edit', 'AccountController@edit')->name("account.edit");

    Route::post('account/delete', 'AccountController@delete')->name("account.delete");

    Route::get('account/get', 'AccountController@get')->name("account.get");

    Route::get('account/get-by-url', 'AccountController@getByUrl')->name("account.getByUrl");

});
