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
//Route::get('/win/list', ['App\Http\Controllers\WinListController', 'index']);

// this is the part that is listing all categorie
Route::get('/categories/list', ['App\Http\Controllers\CategoriesController', 'index']);

//Route::get('retrieve', [CustomerStakeController::class, 'index']);

            Route::group(['prefix' => 'v1/admin'], function () {
                Route::post('/login', ['App\Http\Controllers\Auth\AuthController', 'login']);
                Route::get('/register-user', ['App\Http\Controllers\Auth\AuthController', 'registerUser']);
                Route::get('/test', ['App\Http\Controllers\Auth\AuthController', 'test']);

                Route::group(['middleware' => ['auth:sanctum']], function () {
                    Route::get('/category/create', ['App\Http\Controllers\CategoriesController', 'store']);
                    Route::get('/sub-category/create', ['App\Http\Controllers\SubCategoryController', 'store']);
                    Route::post('/winning-tags/create', ['App\Http\Controllers\WinningTagsController', 'store']);
                    Route::get('/customer-stake', ['App\Http\Controllers\CustomerStakeController', 'index']);
                    Route::get('/customer-stake', ['App\Http\Controllers\CustomerStakeController', 'show']);
                    Route::get('/customer-stake/totalstake', ['App\Http\Controllers\CustomerStakeController', 'getTotalStakes']);
                    Route::get('/winning-tags', ['App\Http\Controllers\WinningTagsController', 'index']);
                    Route::get('/categories', ['App\Http\Controllers\CategoriesController', 'index']);

                    Route::post('/stake/numbers/add', ['App\Http\Controllers\StakeNumbersController', 'store']);
                    Route::get('/stake/numbers', ['App\Http\Controllers\StakeNumbersController', 'index']);
                    Route::post('/customer/wins', ['App\Http\Controllers\WinListController', 'index']);
                    Route::get('/customer/winners', ['App\Http\Controllers\WinListController', 'getAllWinners']);
                    Route::post('/customer/winners-by-date', ['App\Http\Controllers\WinListController', 'getAllWinnersByDate']);
                    Route::post('/customer/winners-by-category', ['App\Http\Controllers\WinListController', 'getAllWinnersByCategory']);
                    Route::post('/customer/add', ['App\Http\Controllers\NewCustomerController', 'store']);
                    Route::get('/customer/stakes', ['App\Http\Controllers\CustomerStakeController', 'index']);
                    Route::post('/customer/stake/add', ['App\Http\Controllers\CustomerStakeController', 'store']);
                    Route::get('/customer/stake/get-user-stakes/{userId}', ['App\Http\Controllers\CustomerStakeController', 'getUserStakes']);
                    Route::get('/subcategories', ['App\Http\Controllers\SubCategories', 'show']);
                });
            });
            Route::namespace('App\Http\Controllers')->group(function () {
                Route::group(['prefix' => '/v1'], function () {
                    Route::post('/login', ['App\Http\Controllers\Auth\AuthController', 'login']);
                    Route::get('/logout', ['App\Http\Controllers\Auth\AuthController', 'logout']);
                    Route::get('/winning-tags', ['App\Http\Controllers\WinningTagsController', 'index']);
                    Route::get('/categories', ['App\Http\Controllers\CategoriesController', 'index']);
                    Route::post('/winning-tags', ['App\Http\Controllers\WinningTagsController', 'index']);
                    Route::get('/category/winning-tags', ['App\Http\Controllers\WinningTagsController', 'getTag']);
                    Route::get('/get-tools', ['App\Http\Controllers\WinningTagsController', 'getTools']);
                    Route::get('/get-machines', ['App\Http\Controllers\WinningTagsController', 'getMachines']);
                    Route::get('/stake/numbers', ['App\Http\Controllers\StakeNumbersController', 'index']);
                    Route::get('/get-banks', ['App\Http\Controllers\BankAccountController', 'getBanks']);
                });

                Route::group(['prefix' => 'v1/customer'], function () {

                    Route::get('/send-notification', ['App\Http\Controllers\Auth\AuthController', 'sendNotification']);
                    Route::get('/get-notifications', ['App\Http\Controllers\Auth\AuthController', 'getNotification']);
                    Route::post('/register-user', ['App\Http\Controllers\Auth\AuthController', 'registerUser']);
                    Route::get('/get-raffles', ['App\Http\Controllers\CustomerStakeController', 'getRaffles']);
                    Route::post('/verify-code', ['App\Http\Controllers\Auth\AuthController', 'verifyCode']);
                    Route::post('/forgot-password', ['App\Http\Controllers\Auth\AuthController', 'forgotPassword']);
                    Route::get('/dashboard', ['App\Http\Controllers\CustomerStakeController', 'dashboard']);
                    Route::post('/account/create', ['App\Http\Controllers\BankAccountController', 'store']);
                    Route::get('/profile', ['App\Http\Controllers\BankAccountController', 'getProfile']);
                    Route::post('/stake/add', ['App\Http\Controllers\CustomerStakeController', 'store']);
                    Route::get('/get-history', ['App\Http\Controllers\TransactionsController', 'getTransactionHistory']);
                    Route::get('/get-credit-history', ['App\Http\Controllers\TransactionsController', 'getTransactionCreditHistory']);
                    Route::get('/get-pending-withdrawal', ['App\Http\Controllers\TransactionsController', 'getPendingWithdrawals']);
                    Route::get('/get-debits-history', ['App\Http\Controllers\TransactionsController', 'getTransactionDebitHistory']);
                    Route::get('/raffles/all', ['App\Http\Controllers\CustomerStakeController', 'getStakeHistory']);
                    Route::get('/raffles/active', ['App\Http\Controllers\CustomerStakeController', 'getActiveStakeHistory']);
                    Route::get('/dashboard', ['App\Http\Controllers\CustomerStakeController', 'dashboard']);
                    Route::post('/add-fund', ['App\Http\Controllers\TransactionsController', 'addFund']);
                    Route::post('/verify-otp', ['App\Http\Controllers\Auth\AuthController', 'verifyOTP']);
                    Route::post('/withdrawal', ['App\Http\Controllers\TransactionsController', 'withdrawal']);
                    Route::group(['prefix' => 'update'], function () {
                        Route::post('/password', ['App\Http\Controllers\Auth\AuthController', 'updatePassword']);
                    });

                });

                Route::group(['prefix' => 'v1/admin'], function () {
            //        Route::group(['middleware' => ['auth:sanctum']], function () {
                        Route::get('/winning-tags/{i}', ['App\Http\Controllers\WinningTagsController', 'adminGetTags']);
                        Route::get('/dashboard', ['App\Http\Controllers\AdminController', 'dashboard']);
                        Route::patch('/update/winning-tags/{i}', ['App\Http\Controllers\AdminController', 'updateWinningTag']);
                        Route::get('/category/winning-tags/{i}', ['App\Http\Controllers\WinningTagsController', 'getSingleTag']);
                        Route::post('/winning-tags/create', ['App\Http\Controllers\WinningTagsController', 'store']);
                        Route::patch('/stop-raffle-draw', ['App\Http\Controllers\WinningTagsController', 'stopDraw']);
                        Route::patch('/winning-tags', ['App\Http\Controllers\WinningTagsController', 'update']);
                        Route::get('/bank-accounts', ['App\Http\Controllers\BankAccountController', 'getAllAccounts']);
                        Route::post('/start-a-raffle', ['App\Http\Controllers\CustomerStakeController', 'openStaking']);
                        Route::post('/start-a-raffle', ['App\Http\Controllers\CustomerStakeController', 'openStaking']);
                        Route::get('/get-all-draw', ['App\Http\Controllers\CustomerStakeController', 'getAllDraws']);
                        Route::post('/win-number/create', ['App\Http\Controllers\WinNumbersController', 'store']);
                        Route::get('/categories', ['App\Http\Controllers\CategoriesController', 'index']);
                        Route::post('/category/create', ['App\Http\Controllers\CategoriesController', 'store']);
                        Route::get('/sub-category/create', ['App\Http\Controllers\SubCategoryController', 'store']);
                        Route::get('/customer-stake', ['App\Http\Controllers\CustomerStakeController', 'index']);
                        Route::get('/customers', ['App\Http\Controllers\AdminController', 'customers']);
                        Route::get('/customer-stakefilter', ['App\Http\Controllers\CustomerStakeController', 'customers_by_filter']);
                        Route::get('/customer-stake/totalstake', ['App\Http\Controllers\CustomerStakeController', 'getTotalStakes']);
                        Route::post('/stake/numbers/add', ['App\Http\Controllers\StakeNumbersController', 'store']);
                        Route::post('/customer/wins', ['App\Http\Controllers\WinListController', 'index']);
                        Route::post('/customer/search-by-date', ['App\Http\Controllers\AdminController', 'searchByDate']);
                        Route::post('/customer/winners-by-date', ['App\Http\Controllers\WinListController', 'getAllWinnersByDate']);
                        Route::post('/customer/winners-by-category', ['App\Http\Controllers\WinListController', 'getAllWinnersByCategory']);
                        Route::get('/customer/stakes', ['App\Http\Controllers\CustomerStakeController', 'index']);
                        Route::get('/customer/transactions', ['App\Http\Controllers\TransactionsController', 'getAllTransactionHistory']);
                        Route::patch('/stake/price/{id}', ['App\Http\Controllers\WinningTagsController', 'getAllTransactionHistory']);
                        Route::get('/pending-withdrawal', ['App\Http\Controllers\TransactionsController', 'getWithdrawals']);
                        Route::patch('/update/pending-withdrawal/{i}', ['App\Http\Controllers\TransactionsController', 'updatePendingWithdrawal']);

            //        });
                });
            });
