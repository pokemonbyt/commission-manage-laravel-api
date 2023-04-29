<?php
/**
 * UEditor富文本模块
 */
Route::namespace('UEditor')->group(function () {
    Route::any('ueditor/upload', 'UEditorController@upload')->name("ueditor.upload");
});
