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

Route::get('/admin', 'Admin\IndexController@index')->name('admin.index');

Route::group([
    'prefix' =>'news',
    'namespace' => 'News'
], function () {
    Route::get('/', 'NewsController@index')->name('news');
    Route::get('/{id}', 'NewsController@show')->name('newsOne');
});



Route::get('/categories', 'CategoryController@index')->name('categories');
Route::get('/categories/{name}', 'CategoryController@show')->name('newsByCategories');




Auth::routes();
