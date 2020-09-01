<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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
    // Users
    Route::get('users', 'UserController@index')->middleware('isSuperAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isMaster');
});
