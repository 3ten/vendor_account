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

Route::get('/{any}', 'AppController@index')->where('any', '.*'); 

Route::group(['middleware' => 'cors'], function () {
    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/login', 'AuthController@login');
});

Route::group(['middleware' => 'jwt.auth'], function(){
    Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');
});
    
Route::group(['middleware' => 'jwt.refresh'], function(){
    Route::get('auth/refresh', 'AuthController@refresh');
});




