<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::namespace('Api')->prefix('v1')->group(function () {
    /**
     * 用户登录
     */
    Route::namespace('Auth')->group(function () {
        Route::post('auth/login', 'AuthController@login')->name("auth.login");

        /**
         * 用于测试
         */
        if (app()->environment('local')) {
            Route::get('auth/test', 'AuthController@test')->name("auth.test");
        }
    });

    /**
     * Log
     */
    Route::namespace('Log')->group(function () {
        Route::post('log/write-log-with-body', 'LogController@writeLogWithBody')->name("log.writeLogWithBody");
    });

    /**
     * 语言列表
     */
    Route::namespace('Translation')->group(function () {
        Route::get('translation/languages', 'TranslationController@languages')->name("translation.languages");
    });

    /**
     * 初始化项目的超级管理员
     */
    Route::namespace('Init')->group(function () {
        Route::post('init/default-role', 'InitController@initDefaultRole')->name("init.initDefaultRole");

        Route::post('init/super-admin', 'InitController@initSuperAdmin')->name("init.initSuperAdmin");
    });
    
    Route::namespace('User')->group(function () {
    /**
     * 用户基本模块
     */
    Route::post('user/create-account', 'UserController@createAccount')->name("user.createAccount");
    });

    /**
     * 验证码模块
     */
    require 'modules/captcha.php';

    Route::middleware(['api.refresh'])->group(function () {
        /**
         * 认证模块
         */
        require 'modules/auth.php';

        /**
         * 用户模块
         */
        require 'modules/user.php';

        /**
         * 权限模块
         */
        require 'modules/permission.php';

        /**
         * 日志模块
         */
        require 'modules/log.php';

        /**
         * 翻译模块
         */
        require 'modules/translation.php';

        /**
         * 资源管理模块
         */
        require 'modules/resources.php';

        /**
         * 缓存管理模块
         */
        require 'modules/redis_manage.php';

        /**
         * ueditor富文本模块
         */
        require 'modules/ueditor.php';

        /**
         * 项目初始化模块
         */
        require 'modules/init.php';

        /**
         * 激活模块
         */
        require 'modules/activation.php';

        /**
         * 网址模块
         */
        require 'modules/url.php';

        /**
         * 账本模块
         */
        require 'modules/account.php';

        /**
         * 关联模块
         */
        require 'modules/user_has_url_and_account.php';

    });
});
