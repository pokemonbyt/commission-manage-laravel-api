<?php
/**
 * 网址模块
 */
Route::namespace('Url')->group(function () {
    Route::post('url/create', 'UrlController@create')->name("url.create");

    Route::post('url/edit', 'UrlController@edit')->name("url.edit");

    Route::post('url/delete', 'UrlController@delete')->name("url.delete");

    Route::get('url/get', 'UrlController@get')->name("url.get");

});
