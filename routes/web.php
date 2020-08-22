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
    Route::match(['get', 'post'],'/create', 'IndexController@create')->name('create'); // переделать на create
    Route::match(['get', 'post'],'/download', 'IndexController@download')->name('download');
});

Route::group([
    'prefix' =>'news',
    'namespace' => 'News',
    'as' => 'news.'
], function () {
    Route::get('/', 'NewsController@index')->name('index');
    Route::get('/one/{id}', 'NewsController@show')->name('show');
    Route::group([
        'as' => 'category.'
    ], function() {
        Route::get('/category', 'CategoryController@index')->name('index');
        Route::get('/category/{name}', 'CategoryController@show')->name('show');
    });
});


Auth::routes();
