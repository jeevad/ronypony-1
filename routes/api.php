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

Route::post('profiles', 'ProfilesController@store');
Route::prefix('auth')->namespace('Auth')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('password/email', 'ForgotPasswordController');
    Route::post('password/reset', 'ResetPasswordController');
});
// Protected routes
Route::middleware('jwt.verify')->group(function () {
    Route::prefix('auth')->namespace('Auth')->group(function () {
        Route::get('email/verify/{id}', 'VerificationController@verify');
        Route::get('email/resend', 'VerificationController@resend');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });
    Route::get('profiles/{profile}', 'ProfilesController@show');
    Route::apiResource('addresses', 'User\AddressController');
    Route::patch('addresses/{address}/mark-default', 'User\AddressController@markAsDefault');
});