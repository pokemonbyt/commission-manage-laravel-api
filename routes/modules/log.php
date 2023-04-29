<?php
/**
 * Log模块
 */
Route::namespace('Log')->group(function () {
    Route::get('log/get-client-log', 'LogController@getClientLog')->name("log.getClientLog");

    Route::get('log/get-user-visitor-log', 'LogController@getUserVisitorLog')->name("log.getUserVisitorLog");

    Route::get('log/get-me-visitor-log', 'LogController@getMeVisitorLog')->name("log.getMeVisitorLog");

    Route::get('log/list-history-log', 'LogController@listLogVisitor')->name("log.listLogVisitor");

    Route::get('log/me-history-log', 'LogController@meLogVisitor')->name("log.meLogVisitor");
});
