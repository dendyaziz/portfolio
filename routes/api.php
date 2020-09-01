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

    // Player
    Route::post('register', 'AuthPlayerController@register');
    Route::post('login', 'AuthPlayerController@login');
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
    // Questions
    Route::get('questions', 'QuestionController@index')->middleware('isMaster');
    Route::post('blue_questions', 'BlueQuestionController@store')->middleware('isMaster');

    // Islands
    Route::get('islands', 'IslandController@index')->middleware('isMaster');
    Route::post('islands', 'IslandController@store')->middleware('isSuperAdmin');

    // Game
    Route::get('games', 'GameController@index')->middleware('isMaster');
    Route::post('games', 'GameController@store')->middleware('isPlayer');

    // Step
    Route::get('steps', 'StepController@index')->middleware('isMaster');
    Route::get('steps/{id}', 'StepController@show')->middleware('isMaster');
    Route::post('steps', 'StepController@store')->middleware('isSuperAdmin');
    Route::put('steps/{id}/square', 'StepController@updateSquare')->middleware('isMaster');

    // Square
    Route::get('squares', 'SquareController@index')->middleware('isMaster');
    Route::get('squares/list', 'SquareController@list')->middleware('isMaster');
    Route::post('squares', 'SquareController@store')->middleware('isSuperAdmin');
    Route::delete('squares/{id}', 'SquareController@destroy')->middleware('isSuperAdmin');

    // Users
    Route::get('users', 'UserController@index')->middleware('isSuperAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isMaster');
});
