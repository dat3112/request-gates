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

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('/forgot-password', 'UserController@forgotPassword');
    Route::post('/reset-password', 'UserController@resetPassword');
    Route::get('/login/google/callback', 'UserController@callBackGoogle');
    Route::group(['as' => 'api.v1.', 'middleware' => 'jwt.auth'], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'UserController@index');
            Route::get('/search-user', 'UserController@searchUser');
            Route::get('/find-user/{role}', 'UserController@findByRoleId');
            Route::post('/change-password', 'UserController@changePassword');
            Route::post('/status/{id}', 'UserController@updateStatusUser')->middleware('rolecheck:ADMIN');
            Route::post('/update/{id}', 'UserController@updateUser')->middleware('rolecheck:ADMIN');
            Route::post('/create-user', 'UserController@createUser')->middleware('rolecheck:ADMIN');
            Route::post('/setting-account', 'UserController@settingAccount');
        });
        Route::group(['prefix' => 'statuses'], function () {
            Route::get('/', 'StatusController@index');
        });
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', 'CategoryController@index');
        });
        Route::group(['prefix' => 'categories', 'middleware' => 'rolecheck:ADMIN'], function () {
            Route::get('/detail/{id}', 'CategoryController@detail');
            Route::post('/store', 'CategoryController@store');
            Route::post('/update/{id}', 'CategoryController@update');
        });
        Route::group(['prefix' => 'department', 'middleware' => 'rolecheck:ADMIN'], function () {
            Route::post('/store', 'DepartmentController@store');
            Route::post('/update/{id}', 'DepartmentController@update');
        });
        Route::group(['prefix' => 'department'], function () {
            Route::get('/', 'DepartmentController@index');
        });
        Route::group(['prefix' => 'priorities'], function () {
            Route::get('/', 'PriorityController@index');
        });
        Route::group(['prefix' => 'request'], function () {
            Route::get('/list-request', 'RequestController@index');
            Route::post('/store', 'RequestController@store');
            Route::get('/detail/{id}', 'RequestController@detail');
            Route::post('/update/{id}', 'RequestController@update');
            Route::post('/destroy/{id}', 'RequestController@destroy');
            Route::get('/my-request', 'RequestController@myRequest');
            Route::post('/approve/{id}', 'RequestController@approve')->middleware('rolecheck:ADMIN|QLBP');
            Route::post('/reject/{id}', 'RequestController@rejectRequest')->middleware('rolecheck:ADMIN|QLBP');
            Route::get('/department-request', 'RequestController@showDepartmentRequest')->middleware('rolecheck:QLBP');
        });
        Route::group(['prefix' => 'admin/request', 'middleware' => 'rolecheck:ADMIN'], function () {
            Route::get('/', 'RequestController@adminRequest');
            Route::post('/update/{id}', 'RequestController@updateAdmin');
        });
        Route::apiResource('history-request', 'HistoryRequestController');
        Route::apiResource('comment', 'CommentController');
    });
});

Route::group(['namespace' => 'Api\Auth'], function () {
    Route::prefix('/user')->group(function () {
        Route::post('/login', 'LoginController@login')->name('login')->middleware('statuscheck', 'throttle:10,2');
        Route::group(['middleware' => 'jwt.auth'], function () {
            Route::get('/logout', 'LoginController@logout')->name('logout');
            Route::post('/refresh', 'LoginController@refresh')->name('refresh');
            Route::get('/me', 'LoginController@getMe')->name('getMe');
        });
    });
});
