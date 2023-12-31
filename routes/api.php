<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('generate-docs', function (){
    $output = [];
    \Artisan::call('l5:generate', $output);
    \Artisan::call('migrate', $output);
    dd($output);
});
Route::get('/categories/list', ['App\Http\Controllers\CategoriesController', 'index']);

Route::group(['prefix' => 'v1/customer'], function () {
    Route::post('/register-user', ['App\Http\Controllers\Auth\AuthController', 'registerCustomer']);
    Route::get('/send-notification', ['App\Http\Controllers\Auth\AuthController', 'sendNotification']);
    Route::get('/get-notifications', ['App\Http\Controllers\Auth\AuthController', 'getNotification']);
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
    Route::get('/get-withdrawal', ['App\Http\Controllers\TransactionsController', 'getWithdrawal']);
    Route::post('/check-balance', ['App\Http\Controllers\TransactionsController', 'checkBalance']);
    Route::group(['prefix' => 'update'], function () {
        Route::post('/password', ['App\Http\Controllers\Auth\AuthController', 'updatePassword']);
    });

});

    Route::group(['prefix' => 'v1/admin'], function () {
        Route::post('/login', ['App\Http\Controllers\Auth\AuthController', 'login']);
        Route::get('/register-user', ['App\Http\Controllers\Auth\AuthController', 'registerUser']);
        Route::get('/test', ['App\Http\Controllers\Auth\AuthController', 'test']);

    });
    Route::namespace('App\Http\Controllers')->group(function () {
        Route::group(['prefix' => '/v1'], function () {

            Route::get('/get-flw-pub-key', ['App\Http\Controllers\Auth\AuthController', 'getFlwPubKey']);
            Route::get('/get-flw-sec-key', ['App\Http\Controllers\Auth\AuthController', 'getFlwSecKey']);
            Route::get('/get-flw-enc-key', ['App\Http\Controllers\Auth\AuthController', 'getFlwEncKey']);
            Route::get('/get-stakes', ['App\Http\Controllers\TransactionsController', 'getStakes']);
            Route::get('/get-wins', ['App\Http\Controllers\TransactionsController', 'getWins']);
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
            Route::patch('/create-pin', ['App\Http\Controllers\Auth\AuthController', 'createPin']);
            Route::post('/validate-pin', ['App\Http\Controllers\Auth\AuthController', 'validatePin']);

        Route::group(['prefix' => '/agent'], function () {
            Route::post('/login', ['App\Http\Controllers\Auth\AuthController', 'login']);
            Route::post('/verify-otp', ['App\Http\Controllers\Auth\AuthController', 'verifyCode']);
            Route::get('/get-states', ['App\Http\Controllers\Auth\AuthController', 'getStates']);
            Route::get('get-raffles', ['App\Http\Controllers\AgentController', 'getRaffles']);
            Route::get('/logout', ['App\Http\Controllers\Auth\AuthController', 'logout']);
            Route::get('/categories', ['App\Http\Controllers\CategoriesController', 'index']);
            Route::get('/winning-tags', ['App\Http\Controllers\WinningTagsController', 'agentGetTags']);
            Route::get('/get-raffle-with-id/{i}', ['App\Http\Controllers\WinningTagsController', 'getRafflesWithId']);
            Route::post('/play-raffle', ['App\Http\Controllers\AgentController', 'store']);
            Route::get('/all-stakes', ['App\Http\Controllers\AgentController', 'allStakes']);
            Route::get('/all-highest-number', ['App\Http\Controllers\AgentController', 'getHighestNumber']);
            Route::get('/get-raffle-status', ['App\Http\Controllers\AgentController', 'getRaffleStatus']);

            Route::group(['middleware' => ['auth:sanctum']], function () {
                Route::post('/create', ['App\Http\Controllers\Auth\AuthController', 'registerAgent']);
                Route::post('/validate-pin', ['App\Http\Controllers\AgentController', 'validatePin']);
                Route::post('/check-balance', ['App\Http\Controllers\AgentController', 'checkBalance']);
                Route::post('/payment/create', ['App\Http\Controllers\AgentController', 'createPayment']);
                Route::patch('/payment/cancelled/{i}', ['App\Http\Controllers\AgentController', 'updatePayment']);
                Route::patch('/payment/completed/{i}', ['App\Http\Controllers\AgentController', 'successfulPayment']);
            });
        });

        Route::group(['prefix' => '/admin'], function () {
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
                Route::get('/customer-stake-filter', ['App\Http\Controllers\CustomerStakeController', 'customers_by_filter']);
                Route::get('/customer-stake/total-stake', ['App\Http\Controllers\CustomerStakeController', 'getTotalStakes']);
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
});
