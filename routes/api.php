<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/v1/refresh-token',  ['App\Http\Controllers\Auth\AuthController', 'refreshToken'])->middleware(['auth:sanctum',  'ability:'.\App\Enums\TokenAbility::ISSUE_ACCESS_TOKEN->value,]);

Route::get('generate-docs', function (){
    $output = [];
    \Artisan::call('l5-swagger:generate', $output);
    \Artisan::call('migrate', $output);
    dd($output);
});
Route::get('/categories/list', ['App\Http\Controllers\CategoriesController', 'index']);
Route::get('/generate-stake-platform-ref',function (){
    $platform = \App\Models\StakePlatform::all();

    foreach ($platform as $key => $val){
        \App\Models\StakePlatform::where("id", $val->id)->update(["platform_ref" => \Illuminate\Support\Str::random(50)]);
    }
});
Route::get('/generate-cat-ref',function (){
    $platform = \App\Models\Categories::all();

    foreach ($platform as $key => $val){
        \App\Models\Categories::where("id", $val->id)->update(["cat_ref" => \Illuminate\Support\Str::random(20)]);
    }
});

Route::get('/populate-agent-stake-table',function (){
    $platform = \App\Models\AgentStakes::all();

    for ($i=1; $i <= 30; $i++){
        $amount =  random_int(100, 999);
        $ref = \Illuminate\Support\Str::random(5);
        \App\Models\AgentStakes::create([
            "user_id" => 1,
            "ticket_id" => $ref,
            "stake_price" => $amount,
            "stake_number" => random_int(100, 999),
            "win" => random_int(0, 1),
            "month" => random_int(1, 12),
            "year" =>  random_int(2023, 2025),
            "winning_tags_id" =>  random_int(1, 4),
            "category_id" =>  random_int(1, 4),
            "agent_id" => 1,
            "active" =>  random_int(0, 1),
            "stake_platform_id" =>  random_int(1, 5),
            "role" =>  "Agent",
            ]);


        $platform = \App\Models\AgentTransactionHistory::all();

        for ($i=1; $i <= 30; $i++){
            \App\Models\AgentTransactionHistory::create([
                "user_id" => 1,
                "transaction_ref" => $ref,
                "amount" => $amount,
                "transaction_type" => "Credit",
                "agent_id" => 1,
                "description" => "Added Fund",
                "role" =>  "Agent",
            ]);
        }
    }
});

Route::get('/generate-tags-ref',function (){
    $platform = \App\Models\WinningTags::all();

    foreach ($platform as $key => $val){
        \App\Models\WinningTags::where("id", $val->id)->update(["win_tag_ref" => \Illuminate\Support\Str::random(20)]);
    }
});
Route::group(['prefix' => 'v1/customer'], function () {
    Route::post('/register-user', ['App\Http\Controllers\Auth\AuthController', 'registerCustomer']);
    Route::post('/verify-code', ['App\Http\Controllers\Auth\AuthController', 'verifyCode']);
    Route::post('/verify-otp', ['App\Http\Controllers\Auth\AuthController', 'verifyOTP']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/send-notification', ['App\Http\Controllers\Auth\AuthController', 'sendNotification']);
        Route::get('/get-notifications', ['App\Http\Controllers\Auth\AuthController', 'getNotification']);
        Route::get('/get-raffles', ['App\Http\Controllers\CustomerStakeController', 'getRaffles']);
        Route::post('/forgot-password', ['App\Http\Controllers\Auth\AuthController', 'forgotPassword']);
        Route::get('/dashboard', ['App\Http\Controllers\CustomerStakeController', 'dashboard']);
        Route::post('/account/create', ['App\Http\Controllers\BankAccountController', 'store']);
        Route::get('/account', ['App\Http\Controllers\BankAccountController', 'getAccount']);
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
        Route::post('/withdrawal', ['App\Http\Controllers\TransactionsController', 'withdrawal']);
        Route::get('/get-withdrawal', ['App\Http\Controllers\TransactionsController', 'getWithdrawal']);
        Route::post('/check-balance', ['App\Http\Controllers\TransactionsController', 'checkBalance']);
        Route::group(['prefix' => 'update'], function () {
            Route::post('/password', ['App\Http\Controllers\Auth\AuthController', 'updatePassword']);
            Route::patch('/profile', ['App\Http\Controllers\Auth\AuthController', 'updateProfile']);
        });
    });

});

    Route::group(['prefix' => 'v1/admin'], function () {
        Route::post('/login', ['App\Http\Controllers\Auth\AuthController', 'login']);
        Route::get('/register-user', ['App\Http\Controllers\Auth\AuthController', 'registerUser']);
        Route::get('/test', ['App\Http\Controllers\Auth\AuthController', 'test']);

    });
    Route::namespace('App\Http\Controllers')->group(function () {

        Route::group(['prefix' => '/v1'], function () {
            Route::post('/login', ['App\Http\Controllers\Auth\AuthController', 'login']);
            Route::group(['middleware' => ['auth:sanctum']], function () {
                Route::get('/get-flw-pub-key', ['App\Http\Controllers\Auth\AuthController', 'getFlwPubKey']);
                Route::get('/get-flw-sec-key', ['App\Http\Controllers\Auth\AuthController', 'getFlwSecKey']);
                Route::get('/get-flw-enc-key', ['App\Http\Controllers\Auth\AuthController', 'getFlwEncKey']);
                Route::get('/get-stakes', ['App\Http\Controllers\TransactionsController', 'getStakes']);
                Route::get('/get-wins', ['App\Http\Controllers\TransactionsController', 'getWins']);
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
                Route::get('/get-agents', ['App\Http\Controllers\AdminController', 'getAgents']);
            });
        Route::group(['prefix' => '/agent'], function () {
            Route::post('/login', ['App\Http\Controllers\Auth\AuthController', 'login']);
            Route::post('/verify-otp', ['App\Http\Controllers\Auth\AuthController', 'verifyCode']);
            Route::post('/create', ['App\Http\Controllers\Auth\AuthController', 'registerAgent']);
            Route::get('/get-states', ['App\Http\Controllers\Auth\AuthController', 'getStates']);
            Route::get('/logout', ['App\Http\Controllers\Auth\AuthController', 'logout']);

            Route::group(['middleware' => ['auth:sanctum']], function () {
                Route::get('get-raffles', ['App\Http\Controllers\AgentController', 'getRaffles']);
                Route::get('/get-raffle-with-id/{i}', ['App\Http\Controllers\WinningTagsController', 'getRafflesWithId']);
                Route::get('/winning-tags', ['App\Http\Controllers\WinningTagsController', 'agentGetTags']);
                Route::get('/categories', ['App\Http\Controllers\CategoriesController', 'index']);
                Route::post('/play-raffle', ['App\Http\Controllers\AgentController', 'store']);
                Route::get('/all-stakes', ['App\Http\Controllers\AgentController', 'allStakes']);
                Route::get('/all-highest-number', ['App\Http\Controllers\AgentController', 'getHighestNumber']);
                Route::get('/check-raffle/{id}', ['App\Http\Controllers\AgentController', 'getRaffleStatus']);
                Route::get('/get-transactions', ['App\Http\Controllers\AgentController', 'getTransactions']);
                Route::post('/validate-pin', ['App\Http\Controllers\AgentController', 'validatePin']);
                Route::post('/check-balance', ['App\Http\Controllers\AgentController', 'checkBalance']);
                Route::post('/payment/create', ['App\Http\Controllers\AgentController', 'createPayment']);
                Route::post('/payment/cancelled', ['App\Http\Controllers\AgentController', 'updatePayment']);
                Route::patch('/payment/completed/{i}', ['App\Http\Controllers\AgentController', 'successfulPayment']);
            });
        });

        Route::group(['prefix' => '/admin'], function () {
            Route::group(['middleware' => ['auth:sanctum']], function () {
                Route::get('/agent-raffles/{i}', ['App\Http\Controllers\AdminController', 'adminGetTags']);
                Route::get('/winning-tags/{i}', ['App\Http\Controllers\WinningTagsController', 'adminGetTags']);
                Route::get('/dashboard', ['App\Http\Controllers\AdminController', 'dashboard']);
                Route::patch('/update/winning-tags/{i}', ['App\Http\Controllers\AdminController', 'updateWinningTag']);
                Route::get('/category/winning-tags/{i}', ['App\Http\Controllers\WinningTagsController', 'getSingleTag']);
                Route::post('/winning-tags/create', ['App\Http\Controllers\WinningTagsController', 'store']);
                Route::patch('/stop-raffle-draw', ['App\Http\Controllers\WinningTagsController', 'stopDraw']);
                Route::patch('/winning-tags', ['App\Http\Controllers\WinningTagsController', 'update']);
                Route::get('/bank-accounts', ['App\Http\Controllers\BankAccountController', 'getAllAccounts']);
                Route::post('/start-a-raffle', ['App\Http\Controllers\CustomerStakeController', 'openStaking']);
                Route::get('/get-all-draw', ['App\Http\Controllers\CustomerStakeController', 'getAllDraws']);
                Route::post('/win-number/create', ['App\Http\Controllers\WinNumbersController', 'store']);
                Route::get('/categories', ['App\Http\Controllers\CategoriesController', 'index']);
                Route::post('/category/create', ['App\Http\Controllers\CategoriesController', 'store']);
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
                Route::get('/agent/transactions', ['App\Http\Controllers\TransactionsController', 'getAllAgentTransactionHistory']);
                Route::patch('/stake/price/{id}', ['App\Http\Controllers\WinningTagsController', 'getAllTransactionHistory']);
                Route::get('/pending-withdrawal', ['App\Http\Controllers\TransactionsController', 'getWithdrawals']);
            });
        });
    });
});
