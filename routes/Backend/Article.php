<?php

Route::resource('article', 'ArticleController', ['except' => ['show']]);

Route::post('upload-ckimage/', 'ArticleController@uploadCkeditorImage');

/**
 * For DataTables
 */
Route::get('article/get', 'ArticleController@get')->name('article.get');
Route::get('article/', 'ArticleController@index')->name('article.index');