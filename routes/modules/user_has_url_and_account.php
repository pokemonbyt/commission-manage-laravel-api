<?php
/**
 * 网址模块
 */
Route::namespace('UserHasUrlAndAccount')->group(function () {
    Route::post('user-has-url-and-account/create', 'UserHasUrlAndAccountController@create')->name("userHasUrlAndAccount.create");

    Route::post('user-has-url-and-account/edit', 'UserHasUrlAndAccountController@edit')->name("userHasUrlAndAccount.edit");

    Route::post('user-has-url-and-account/delete', 'UserHasUrlAndAccountController@delete')->name("userHasUrlAndAccount.delete");

    Route::get('user-has-url-and-account/get', 'UserHasUrlAndAccountController@get')->name("userHasUrlAndAccount.get");

    Route::get('user-has-url-and-account/get-account', 'UserHasUrlAndAccountController@getAccountByUserAndUrl')->name("userHasUrlAndAccount.getAccountByUserAndUrl");

    Route::get('me-has-url-and-account/get-account', 'UserHasUrlAndAccountController@findMe')->name("userHasUrlAndAccount.findMe");

});
