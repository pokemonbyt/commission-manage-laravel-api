<?php
/**
 * 用户模块
 */
Route::namespace('User')->group(function () {
    /**
     * 用户基本模块
     */
    // Route::post('user/create-account', 'UserController@createAccount')->name("user.createAccount");

    Route::get('user/info', 'UserController@info')->name("user.info");

    Route::post('user/edit-info', 'UserController@editUserInfo')->name("user.editUserInfo");

    Route::get('user/all', 'UserController@all')->name("user.all");

    Route::get('user/search', 'UserController@search')->name("user.search");

    Route::get('user/me-profile', 'UserController@meProfile')->name("user.meProfile");

    Route::get('user/profile', 'UserController@profile')->name("user.profile");

    Route::post('user/delete', 'UserController@delete')->name("user.delete");

    Route::post('user/update-type', 'UserController@updateType')->name("user.updateType");

    /**
     * 登录密码模块
     */
    Route::get('user/password/check', 'UserPasswordController@checkDefaultPassword')->name("user.checkDefaultPassword");

    Route::post('user/password/update', 'UserPasswordController@updatePassword')->name("user.updatePassword");

    Route::post('user/password/reset', 'UserPasswordController@resetPassword')->name("user.resetPassword");

    Route::post('user/password/update-user-password', 'UserPasswordController@updateUserPassword')->name("user.updateUserPassword");

    /**
     * 安全密码模块
     */
    Route::post('user/privacy-password', 'UserPasswordController@verifyPrivacyPassword')->name("user.verifyPrivacyPassword");

    Route::get('user/privacy-password/is-verify', 'UserPasswordController@isVerifyPrivacyPassword')->name("user.isVerifyPrivacyPassword");

    Route::get('user/privacy-password/check', 'UserPasswordController@checkDefaultPrivacyPassword')->name("user.checkDefaultPrivacyPassword");

    Route::post('user/privacy-password/create', 'UserPasswordController@createPrivacyPassword')->name("user.createPrivacyPassword");

    Route::post('user/privacy-password/update', 'UserPasswordController@updatePrivacyPassword')->name("user.updatePrivacyPassword");

    Route::post('user/privacy-password/reset', 'UserPasswordController@resetPrivacyPassword')->name("user.resetPrivacyPassword");

    /**
     * 获取我能创建的用户类型
     */
    Route::get('user/user-role/get-register-roles', 'UserController@getRegisterRolesList')->name("user.getRegisterRolesList");


    /**
     * quan ly thong tin agency
     */
    Route::post('user/create-agency-details', 'UserController@createAgencyDetails')->name("user.createAgencyDetails");
    Route::post('user/import-agency-details', 'UserController@importAgencyDetails')->name("user.importAgencyDetails");
    Route::post('user/update-agency-details', 'UserController@updateAgencyDetails')->name("user.updateAgencyDetails");
    Route::post('user/delete-agency-details', 'UserController@deleteAgencyDetails')->name("user.deleteAgencyDetails");
    Route::get('user/get-agency-details', 'UserController@getAgencyDetails')->name("user.getAgencyDetails");

    Route::post('user/create-agency-config', 'UserController@createAgencyManager')->name("user.createAgencyManager");
    Route::post('user/update-agency-config', 'UserController@updateAgencyManager')->name("user.updateAgencyManager");
    Route::post('user/delete-agency-config', 'UserController@deleteAgencyManager')->name("user.deleteAgencyManager");
    Route::get('user/get-agency-config', 'UserController@getAgencyManager')->name("user.getAgencyManager");

    Route::get('user/get-total-win-lose', 'UserController@getTotalWinLose')->name("user.getTotalWinLose");
    Route::get('user/get-total-commission', 'UserController@getTotalCommission')->name("user.getTotalCommission");



});
