<?php
/**
 * 缓存管理
 */
Route::namespace('Redis')->group(function () {
    Route::get('redis/all', 'RedisController@all')->name("redis.all");

    Route::post('redis/delete', 'RedisController@delete')->name("redis.delete");

    Route::post('redis/flushall', 'RedisController@flushall')->name("redis.flushall");
});
