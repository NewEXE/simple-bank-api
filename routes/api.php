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
Route::name('api.')->group(function () {
    Route::post('register-user', 'Api\UserController@store')->name('user.register');
    Route::post('login', 'Auth\LoginController@login')->name('user.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('user.logout');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('user', function (Request $request) {
            return Auth::guard('api')->user();
        });

        Route::get('transactions', 'Api\TransactionController@index')->name('transactions.index');
        Route::get('transactions/{user}/{transaction}', 'Api\TransactionController@show');
        Route::post('transactions', 'Api\TransactionController@store');
        Route::put('transactions', 'Api\TransactionController@update');
        Route::delete('transactions/{transaction}', 'Api\TransactionController@destroy');

    });
});