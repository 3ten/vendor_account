<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');
    Route::get('/getCards', 'FBController@getCards');
    Route::get('/getOrder', 'FBController@getOrder');
    Route::post('/getVendors', 'FBController@getClients')->middleware('isShop');
    Route::post('/saveVendor', 'FBController@saveOptions')->middleware('isShop');
    Route::post('/sendMessage', 'InviteController@sendMessage')->middleware('isShop');
    Route::post('/getOrderList/', 'FBController@getOrderList');
    Route::post('/getOst', 'FBController@getOst');
    Route::post('/getPrix', 'FBController@getPrix');
    Route::post('/getCardAnalysis', 'FBController@getCardAnalysis')->middleware('isVendor');
    Route::post('/getSalesAnalysis', 'FBController@getSalesAnalysis')->middleware('isVendor');
    Route::post('/getCardSales', 'FBController@getCardSales')->middleware('isVendor');
    Route::post('/sendChatMessage', 'MessageController@sendMessage');
    Route::post('/getRelations', 'UsersRelationsController@getRelations');
    Route::post('/saveMessage', 'MessageController@saveMessage');
    Route::post('/getOldMessages', 'MessageController@getOldMessages');
    Route::post('/createRelation', 'UsersRelationsController@createRelation')->middleware('isShop');
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');
    Route::post('parse', 'InviteController@parse');
    Route::group(['middleware' => 'auth:api'], function(){
    Route::get('refresh', 'AuthController@refresh');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::get('/getData', 'GetSalesData@getFBData');
