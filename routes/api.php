<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\CustomerStakeController;

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
//Route::get('retrieve', [CustomerStakeController::class, 'index']);

Route::
        namespace('App\Http\Controllers')->group(function () {
            Route::group(['prefix' => 'v1/admin'], function () {
                Route::post('/login', ['App\Http\Controllers\Auth\AuthController', 'login']);
                Route::get('/register-user', ['App\Http\Controllers\Auth\AuthController', 'registerUser']);
                Route::get('/test', ['App\Http\Controllers\Auth\AuthController', 'test']);

                Route::group(['middleware' => ['auth:sanctum']], function () {
                    Route::get('/category/create', ['App\Http\Controllers\CategoriesController', 'store']);
                    Route::get('/sub-category/create', ['App\Http\Controllers\SubCategoryController', 'store']);
                    Route::post('/winning-tags/create', ['App\Http\Controllers\WinningTagsController', 'store']);
                    Route::get('/customer-stakes', ['App\Http\Controllers\CustomerStakeController', 'index']);
                    Route::get('/customer-stakefilter', ['App\Http\Controllers\CustomerStakeController', 'customers_by_filter']);
                    Route::get('/customer-stake', ['App\Http\Controllers\CustomerStakeController', 'show']);
                    Route::post('/customer-stake/add', ['App\Http\Controllers\CustomerStakeController', 'store']);
                    Route::get('/winning-tags', ['App\Http\Controllers\WinningTagsController', 'index']);
                    Route::get('/categories', ['App\Http\Controllers\CategoriesController', 'index']);
                });
            });
        });