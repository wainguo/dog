<?php

Route::resource('slider', 'SliderController', ['except' => ['show']]);

/**
 * For DataTables
 */
Route::get('slider/get', 'SliderController@get')->name('slider.get');
Route::get('slider/', 'SliderController@index')->name('slider.index');