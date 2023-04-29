<?php
/**
 * 激活模块
 */
Route::namespace('AgencyDetails')->group(function () {
    Route::get('activation/check-active', 'ActivationController@checkIsActive')->name("activation.checkIsActive");

    Route::post('activation/active', 'ActivationController@active')->name("activation.active");

    Route::get('activation/get', 'ActivationController@get')->name("activation.get");
});
