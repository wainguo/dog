<?php

/**
 * Frontend Controllers
 */
Route::get('/', 'FrontendController@index')->name('frontend.index');
Route::get('/about', 'FrontendController@about')->name('frontend.about');
Route::get('/terms', 'FrontendController@terms')->name('frontend.terms');
Route::get('/contact', 'FrontendController@contact')->name('frontend.contact');
Route::get('/youhui', 'FrontendController@youhui')->name('frontend.youhui');
Route::get('/haitao', 'FrontendController@haitao')->name('frontend.haitao');
Route::get('/coupon', 'FrontendController@coupon')->name('frontend.coupon');
Route::get('/news', 'FrontendController@news')->name('frontend.news');
Route::get('/post', 'FrontendController@post')->name('frontend.post');
Route::get('/p/{id}', 'FrontendController@article')->name('frontend.article');

/**
 * These frontend controllers require the user to be logged in
 */
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'User'], function() {
        Route::get('dashboard', 'DashboardController@index')->name('frontend.user.dashboard');
        Route::get('profile/edit', 'ProfileController@edit')->name('frontend.user.profile.edit');
        Route::patch('profile/update', 'ProfileController@update')->name('frontend.user.profile.update');
    });
});

Route::controllers([
    'article'   =>  'ArticleController',
]);

Route::controllers([
    'api/post' => 'Api\AuthRequiredApiController',
    'api/get' => 'Api\PublicApiController',
    'api/upload' => 'Api\UploadController'
]);