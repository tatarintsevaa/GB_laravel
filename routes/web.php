<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index')->name('home');

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'as' => 'admin.'
], function () {
    Route::get('/', 'IndexController@index')->name('index');
    Route::group([
        'prefix' => 'news',
        'as' => 'news.'],
        function () {
            Route::get('/', 'NewsController@index')->name('index');
            Route::get('/create', 'NewsController@create')->name('create');
            Route::match(['get', 'post'], '/download', 'NewsController@download')->name('download');
            Route::get('/edit/{news}', 'NewsController@edit')->name('edit');
            Route::put('/{news}', 'NewsController@update')->name('update');
            Route::post('/', 'NewsController@store')->name('store');
            Route::delete('/{news}', 'NewsController@destroy')->name('destroy');
        });

//    Route::group([
//        'prefix' => 'category',
//        'as' => 'category.'],
//        function () {
//            Route::get('/', 'CategoryController@index')->name('index');
//            Route::get('/create', 'CategoryController@create')->name('create');
//            Route::get('/edit/{category}', 'CategoryController@edit')->name('edit');
//            Route::put('/{category}', 'CategoryController@update')->name('update');
//            Route::post('/', 'CategoryController@store')->name('store');
//            Route::delete('/{category}', 'CategoryController@destroy')->name('destroy');
//        });
    Route::resource('/category', 'CategoryController')->except(['show']);
});



Route::group([
    'prefix' => 'news',
    'namespace' => 'News',
    'as' => 'news.'
], function () {
    Route::get('/', 'NewsController@index')->name('index');
    Route::get('/one/{news}', 'NewsController@show')->name('show');
    Route::group([
        'as' => 'category.'
    ], function () {
        Route::get('/category', 'CategoryController@index')->name('index');
        Route::get('/category/{name}', 'CategoryController@show')->name('show');
    });
});


Auth::routes();
