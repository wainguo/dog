<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'
 */
Route::get('/', 'FrontendController@index')->name('index');
//Route::get('macros', 'FrontendController@macros')->name('macros');
Route::get('/search', 'FrontendController@search')->name('frontend.search');
Route::get('/about', 'FrontendController@about')->name('frontend.about');
Route::get('/astore', 'FrontendController@astore')->name('frontend.astore');
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
 * All route names are prefixed with 'frontend.'
 */
Route::group(['middleware' => 'auth'], function () {
	Route::group(['namespace' => 'User', 'as' => 'user.'], function() {
		/**
		 * User Dashboard Specific
		 */
		Route::get('dashboard', 'DashboardController@index')->name('dashboard');

		/**
		 * User Account Specific
		 */
		Route::get('account', 'AccountController@index')->name('account');

		/**
		 * User Profile Specific
		 */
		Route::patch('profile/update', 'ProfileController@update')->name('profile.update');

        //guoshengxing added
        Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
        Route::get('profile/avatar', 'ProfileController@avatar')->name('profile.avatar');
        Route::post('profile/avatar', 'ProfileController@updateAvatar')->name('profile.update-avatar');

	});
});

Route::resource('article', 'ArticleController');
Route::resource('tool', 'JtmdsToolController');

Route::post('api/upload/image', 'Api\UploadController@postImage');
Route::post('api/upload/slider', 'Api\UploadController@postSlider');
Route::post('api/post/add-category', 'Api\AuthRequiredApiController@postAddCategory');
Route::post('api/post/add-tags', 'Api\AuthRequiredApiController@postAddTags');

Route::get('api/get/more-articles', 'Api\PublicApiController@getMoreArticles');
Route::post('api/get/article/{id}', 'Api\PublicApiController@getArticle');
Route::post('api/get/article/comments', 'Api\PublicApiController@getComments');
Route::post('api/get/article/categories', 'Api\PublicApiController@getCategories');
Route::post('api/get/article/properties', 'Api\PublicApiController@getProperties');
//Route::group(['namespace' => 'User', 'as' => 'user.'], function() {
//    Route::get('api/get', 'Api\PublicApiController@edit')->name('profile.edit');
//});
//Route::controllers([
//    'article'   =>  'ArticleController',
//    'tool'   =>  'JtmdsToolController',
//]);

//Route::controllers([
//    'api/post' => 'Api\AuthRequiredApiController',
//    'api/get' => 'Api\PublicApiController',
//    'api/upload' => 'Api\UploadController'
//]);