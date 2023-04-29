<?php
/**
 * 资源管理模块
 */
Route::namespace('Resources')->group(function () {
    Route::post('resources/upload', 'ResourcesController@upload')->name("resources.upload");

    Route::post('resources/uploads', 'ResourcesController@uploads')->name("resources.uploads");

    Route::post('resources/upload-screenshot', 'ResourcesController@uploadScreenshot')->name("resources.uploadScreenshot");

    Route::post('resources/upload-avatar', 'ResourcesController@uploadAvatar')->name("resources.uploadAvatar");

    Route::post('resources/delete', 'ResourcesController@delete')->name("resources.delete");

    Route::get('resources/download', 'ResourcesController@download')->name("resources.download");

    Route::get('resources/all', 'ResourcesController@all')->name("resources.all");

    Route::get('resources/find-depend', 'ResourcesController@findDepend')->name("resources.findDepend");
});
