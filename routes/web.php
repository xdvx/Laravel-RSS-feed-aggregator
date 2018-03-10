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

Route::get('/', 'MainController@index')->name('index');
Auth::routes();


Route::group(
    ['middleware' => 'auth'],
    function (){
        Route::get('/password/edit', 'Auth\ChangePasswordController@index');
        Route::post('/password/update', 'Auth\ChangePasswordController@update')->name('auth.changepassword');
    });

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => 'auth'
    ],
    function () {
        Route::resource('feeds', 'Admin\FeedsController')->except([
           'show'
        ]);

        Route::resource('categories', 'Admin\CategoriesController')->except([
            'show'
        ]);
    }
);
