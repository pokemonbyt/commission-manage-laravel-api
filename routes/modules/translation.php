<?php
/**
 * 翻译模块
 */
Route::namespace('Translation')->group(function () {
    Route::post('translation/create', 'TranslationController@create')->name("translation.create");

    Route::post('translation/delete', 'TranslationController@delete')->name("translation.delete");

    Route::post('translation/edit', 'TranslationController@edit')->name("translation.edit");

    Route::post('translation/edits', 'TranslationController@edits')->name("translation.edits");

    Route::get('translation/all', 'TranslationController@all')->name("translation.all");

    Route::get('translation/translations', 'TranslationController@listByLanguageEnum')->name("translation.listByLanguageEnum");

    Route::post('translation/import', 'TranslationController@import')->name("translation.import");

    Route::get('translation/test-google-translation', 'TranslationController@testGoogleTranslate')->name("translation.testGoogleTranslate");
});
