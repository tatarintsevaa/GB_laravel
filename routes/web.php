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

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'isAdmin', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});


Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'isAdmin']
], function () {
    Route::get('/', 'IndexController@index')->name('index');
    Route::get('/parser', 'ParserController@index')->name('parser');
    Route::put('/user/{id}/update', 'UsersController@update')->name('user.update');
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
    Route::resource('/users', 'UsersController')->only(['index', 'destroy', 'update']);
    Route::resource('/resource', 'ResourceController')->except(['show']);
});

Route::get('/auth/vk', 'LoginController@loginVK')->name('vkLogin');
Route::get('/auth/vk/response', 'LoginController@responseVK')->name('vkResponse');

Route::get('/auth/fb', 'LoginController@loginFb')->name('fbLogin');
Route::get('/auth/fb/response', 'LoginController@responseFb')->name('fbResponse');

Route::get('/auth/gh', 'LoginController@loginGh')->name('ghLogin');
Route::get('/auth/gh/response', 'LoginController@responseGh')->name('ghResponse');



Route::group([
    'prefix' => 'profile',
    'as' => 'profile.'
    ], function () {
        Route::get( '/{user}', 'ProfileController@index')->name('index');
        Route::post( '/edit', 'ProfileController@edit')->name('edit');
        Route::post( '/editPassword', 'ProfileController@editPassword')->name('editPassword');
        Route::post( '/addAvatar', 'ProfileController@addAvatar')->name('addAvatar');
});

Route::group([
    'prefix' => 'news',
    'namespace' => 'News',
    'as' => 'news.'
], function () {
    Route::get('/', 'NewsController@index')->name('index');
    Route::get('/one/{news}', 'NewsController@show')->name('show');
    Route::get('/search', 'NewsController@search')->name('search');
    Route::group([
        'as' => 'category.'
    ], function () {
        Route::get('/category', 'CategoryController@index')->name('index');
        Route::get('/category/{name}', 'CategoryController@show')->name('show');
    });
});



Route::put('/comment', 'CommentController@store')->name('comment.store');


Auth::routes();
