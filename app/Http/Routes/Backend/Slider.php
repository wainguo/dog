<?php

Route::resource('slider', 'SliderController', ['except' => ['show']]);

/**
 * For DataTables
 */
Route::get('slider/get', 'SliderController@get')->name('admin.slider.get');
Route::get('slider/', 'SliderController@index')->name('admin.slider.index');