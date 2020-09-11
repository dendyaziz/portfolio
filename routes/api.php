<?php

use Illuminate\Support\Facades\Route;

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

Route::post('send_message', 'HomeController@sendMessage');

Route::prefix('auth')->group(function () {

    // Seeker
    Route::post('register', 'AuthSeekerController@register');
    Route::post('login', 'AuthSeekerController@login');
    Route::get('refresh', 'AuthMasterController@refresh');

    // Admin
    Route::post('master/login', 'AuthMasterController@login');
    Route::get('master/refresh', 'AuthMasterController@refresh');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('master/user', 'AuthMasterController@user');
        Route::post('master/logout', 'AuthMasterController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('users', 'UserController@index')->middleware('isSuperAdmin');

    // Users
    Route::get('user', 'UserController@user');
    Route::get('users', 'UserController@index')->middleware('isSuperAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isMaster');
});
