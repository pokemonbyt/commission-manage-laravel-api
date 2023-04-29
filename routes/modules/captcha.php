<?php
/**
 * 验证码模块
 */
Route::namespace('Captcha')->group(function () {
    Route::get('captcha/create', 'CaptchaController@create')->name("captcha.create");
});
