<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::namespace('App\Http\Controllers')->group(function () {
    Route::group(['prefix' => 'v1/user'], function () {
        Route::post('/login', ['App\Http\Controllers\Auth\AuthController', 'login']);
        Route::get('/register-user', ['App\Http\Controllers\Auth\AuthController', 'registerUser']);
        Route::get('/test', ['App\Http\Controllers\Auth\AuthController', 'test']);

        Route::group(['middleware' => ['auth:sanctum']], function ()
        {
            Route::get('/register', ['App\Http\Controllers\Auth\AuthController', 'register']);

        });
    });
});
