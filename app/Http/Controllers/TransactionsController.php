<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddFundResource;
use App\Http\Resources\AgentTransactionResource;
use App\Http\Resources\WithdrawalResource;
use App\Models\AgentTransactionHistory;
use App\Models\BankAccount;
use App\Models\CustomerTransactionHistory;
use App\Models\NewCustomer;
use App\Models\Stake;
use App\Models\Withdrawals;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psy\Util\Json;

class TransactionsController extends Controller
{

    /**
     * @OA\Post  (
     *     path="/api/v1/customer/check-balance",
     *      tags={"Mobile"},
     *     @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="amount",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Balance is greater than amount", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function checkBalance(Request $request, Utils $utils)
    {
        $request->validate([
            "amount" => "required"
        ]);
        $user_id = auth('sanctum')->user()->id;

        $balance = NewCustomer::where("user_id", $user_id)->value("wallet");

        if ($request->get("amount") > $balance)
            return  $utils->message("error", false, 400);
        return  $utils->message("success", true, 200);


    }

    /**
     * @OA\Get (
     *     path="/api/v1/get-wins",
     *      tags={"General"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="user_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Getting Stake successful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getWins(Request $request, Utils $utils): JsonResponse
    {
        $user_id = auth('sanctum')->user()->id;
        $stakes =   Stake::where("user_id", $user_id)->where("win", 1)->with(["winningTags"])->get();
        $sum =   Stake::where("user_id", $user_id)->where("win", 1)->with(["winningTags"])->sum("stake_price");
        $data = [
            "stakes" => $stakes,
            "sum" => $sum
        ];
        return  $utils->message("success", $data, 200);

    }

    /**
     * @OA\Get (
     *     path="/api/v1/get-all-stakes",
     *     tags={"General"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Getting Stake successful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getStakes(Request $request, Utils $utils): JsonResponse
    {
        $user_id = auth('sanctum')->user()->id;

        $stakes =   Stake::where("user_id", $user_id)->with(["winningTags"])->where("role", "Customer")->get();
        $sum =   Stake::where("user_id", $user_id)->with(["winningTags"])->where("role", "Customer")->sum("stake_price");
        $data = [
            "stakes" => $stakes,
            "sum" => $sum
        ];
        return  $utils->message("success", $data, 200);

    }

    public function getAllAgentTransactionHistory(Request $request, Utils $utils)
    {
//        return AgentTransactionHistory::with(["agents"])->get();
        $transaction_history =  AgentTransactionResource::collection(AgentTransactionHistory::with(["agents"])->get());
        $data = [
            "total" => AgentTransactionHistory::sum("amount"),
            "history" => $transaction_history
        ];
        return  $utils->message("success", $data, 200);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/admin/customer/get-history",
     *     summary="List all the transactions",
     *     tags={"Admin"},
     *     @OA\Response(response="200", description="List all the transactions"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getAllTransactionHistory(Request $request, Utils $utils)
    {
        $transaction_history =  AddFundResource::collection(CustomerTransactionHistory::with(["customers"])->where("role", "Customer")->get());
        return  $utils->message("success", $transaction_history, 200);
    }

    public function updatePendingWithdrawal($id, Request $request, Utils $utils)
    {
           $status = Withdrawals::where("id", $id)->update(["status" => "Completed"]);
           if ($status)
               $withdrawal = Withdrawals::with(["user", "customer", "bankAccount"])->get();
        return  $utils->message("success", WithdrawalResource::collection($withdrawal), 200);

    }

    public function getWithdrawals(Utils $utils)
    {
        $withdrawal = Withdrawals::with(["user", "customer", "bankAccount"])->get();
        return  $utils->message("success", WithdrawalResource::collection($withdrawal), 200);
    }
    /**
     * @OA\Get (
     *     path="/api/v1/customer/get-debits-history",
     *     summary="List debit transactions",
     *     tags={"Mobile"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="List debit transactions"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getTransactionDebitHistory(Request $request, Utils $utils): JsonResponse
    {
        $user_id = auth('sanctum')->user()->id;
        $transaction_history = CustomerTransactionHistory::where("user_id", $user_id)->where("transaction_type", "Debit")->get();
        return  $utils->message("success", $transaction_history, 200);
    }

    /**
     * @OA\Get (
     *     path="/api/v1/customer/get-credit-history",
     *      tags={"Mobile"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Registration successful", @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getTransactionCreditHistory(Request $request, Utils $utils): JsonResponse
    {

        $user_id = auth('sanctum')->user()->id;
        $transaction_history = CustomerTransactionHistory::where("user_id", $user_id)->where("transaction_type", "Credit")->get();
        $data = [
          "transaction_history" => $transaction_history,
        ];
        return  $utils->message("success", $data, 200);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/customer/get-history",
     *     summary="List Credit transactions",
     *     tags={"Mobile"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="List transactions"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getTransactionHistory(Request $request, Utils $utils): JsonResponse
    {
        $user_id = auth('sanctum')->user()->id;

        $transaction_history = CustomerTransactionHistory::where("id", $user_id)->get();
        return  $utils->message("success", $transaction_history, 200);
    }

    /**
     * @OA\Get  (
     *     path="/api/v1/customer/get-withdrawal",
     *     summary="Get Withdrawal",
     *     tags={"Mobile"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Getting withdrawal Sucessful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User Not Found", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     * )
     */
    public function getWithdrawal(Request $request, Utils $utils): JsonResponse
    {
        $user_id = auth('sanctum')->user()->id;
        $withdrawals = Withdrawals::where("customer_id", $user_id)->get(["amount", "created_at"]);
        $data = [
            "withdrawals" => $withdrawals,
        ];
        return $utils->message("success", $data , 200);
    }

    /**
     * @OA\Post (
     *     path="/api/v1/customer/withdrawal",
     *     summary="Add Fund",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="Amount",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Withdrawal Successful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User Not Found", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     * )
     */
    public function withdrawal(Request $request, Utils $utils)
    {
        $request->validate([
            "amount" => "required|int|gte:100",
        ]);
        $user_id =  auth('sanctum')->user()->id;
        $amount = $request->get("amount");
        $total = 0;
        $balance = NewCustomer::where("user_id", $user_id)->value("wallet");
        if ($amount > $balance)
            return  $utils->message("error", "Insufficient Fund.", 400);
        if ($amount > 500000)
            return  $utils->message("error", "Your Daily limit is 500,000", 400);

            try {
                return  DB::transaction(function () use ($request, $total, $utils, $amount, $user_id){
                    try {
                        $client = new \GuzzleHttp\Client();
                        $customer = NewCustomer::where("user_id", $user_id)->firstOrFail();
                        $account_bank =  BankAccount::where("user_id", $user_id)->value("bank_code");
                        $account_number =  BankAccount::where("user_id", $user_id)->value("account_number");
                        $narration = "TRF from Raffle9ja to " . $customer->first_name . " " . $customer->last_name . 'with id ' . $user_id ;


                        Log::info("########## Initialize Account Validation  #########");
                        $response = $client->request('POST', 'https://api.ravepay.co/flwv3-pug/getpaidx/api/resolve_account', [
                            'form_params' => [
                                "amount" => $amount,
                                "destbankcode" => $account_bank,
                                "recipientaccount" => $account_number,
                                "PBFPubKey" => env("FLWPUBK_TEST")
                            ],
                            'headers' => [
                                'Accept'     => 'application/json',
                            ]
                        ]);

                        $responses = json_decode($response->getBody()->getContents());

                        if($responses->status === "success"){
                            Log::info("########## Account Validation Successful  #########", json_decode(json_encode($responses), true));

                            $transactionHistory = new Withdrawals();
                            $transactionHistory->user_id = $user_id;
                            $transactionHistory->customer_id = NewCustomer::where("user_id", $user_id)->value("id");
                            $transactionHistory->amount = $amount;
                            $transactionHistory->trx_ref =  "9ja_" .  Str::random(15);
                            $transactionHistory->status = "Pending";
                            $transactionHistory->bank_code =  $account_bank;
                            $transactionHistory->account_number = $account_number;
                            $transactionHistory->narration = "Withdrawal from " . NewCustomer::where("user_id", $user_id)->value("first_name");
                            $transactionHistory->save();
                            Log::info("########## Saving data before transfer  #########", json_decode(json_encode($transactionHistory), true));

                            $paymentResponse = $client->request('POST', 'https://api.flutterwave.com/v3/transfers', [
                                'json' => [
                                    "amount" => $amount,
                                    "account_bank" => $account_bank,
                                    "account_number" => $account_number,
                                    "currency" => "NGN",
                                    "narration" => $narration,
                                    "reference" => "Raffle9ja_". Str::random(20),
                                    "debit_currency" => "NGN",
                                ],
                                'debug' => false,
                                'headers' => [
                                    'Accept'     => 'application/json',
                                    "Authorization" => "Bearer ". env("FLWSEC_TEST")
                                ]
                            ]);

                            $paymentResponses = json_decode($paymentResponse->getBody()->getContents());
                            if($paymentResponses->status === "success"){
                                Log::info("########## Payment Successful  #########", json_decode(json_encode($paymentResponses), true));
                                $transaction = Withdrawals::lockForUpdate()->find($transactionHistory->id);
                                $transaction->account_number = $paymentResponses->data->account_number;
                                $transaction->bank_code = $paymentResponses->data->bank_code;
                                $transaction->account_name = $paymentResponses->data->full_name;
                                $transaction->trx_date = $paymentResponses->data->created_at;
                                $transaction->currency = $paymentResponses->data->currency;
                                $transaction->debit_currency =  $paymentResponses->data->debit_currency;
                                $transaction->fee =  $paymentResponses->data->fee;
                                $transaction->reference =  $paymentResponses->data->reference;
                                $transaction->requires_approval = $paymentResponses->data->requires_approval;
                                $transaction->is_approved = $paymentResponses->data->is_approved;
                                $transaction->bank_name = $paymentResponses->data->bank_name;
                                $transaction->status = "Completed";
                                $transaction->amount_bt = NewCustomer::where("user_id", $user_id)->value("wallet");
                                $transaction->amount_at = NewCustomer::where("user_id", $user_id)->value("wallet") - $amount;
                                $transaction->update();

                                $customerTransactionHistory = new CustomerTransactionHistory();
                                $customerTransactionHistory->amount = $amount;
                                $customerTransactionHistory->user_id = $user_id;
                                $customerTransactionHistory->role = "Customer";
                                $customerTransactionHistory->transaction_type = "Debit";
                                $customerTransactionHistory->description = "TRF FROM RAFFLE9JA to " . $paymentResponses->data->full_name;
                                $customerTransactionHistory->customer_id = NewCustomer::where("user_id", $user_id)->value("id");
                                $customerTransactionHistory->transaction_ref = $paymentResponses->data->reference;
                                $customerTransactionHistory->save();

                                $balance = NewCustomer::where("user_id", $user_id)->value("wallet");
                                $total = $balance - $amount;

                                NewCustomer::lockForUpdate()->where("user_id", $user_id)->update(["wallet" => $total]);
                                $data = [
                                    "newBalance" => NewCustomer::where("user_id", $user_id)->value("wallet"),
                                    "message" => "Your request will be review in 24 hours"
                                ];
                                return $utils->message("success", $data, 200);
                            }
                        }
                        return $utils->message("error", "Network Problem. Please Try again", 400);

                    } catch (\GuzzleHttp\Exception\ClientException $e) {
                        return $utils->message("error", $e->getMessage() , 400);
                    }
                    });
            } catch (\Throwable $e) {
                Log::error("########## ". $e->getMessage() ." #########");
                return $utils->message("error",$e->getMessage() , 404);
            }
    }


    /**
     * @OA\Post (
     *     path="/api/v1/customer/add-fund",
     *     summary="Add Fund",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="Amount",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="trx_ref",
     *         in="query",
     *         description="trx_ref",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Add Fund"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function addFund(Request $request, Utils $utils)
    {
        $request->validate([
            "amount" => "required",
            "trx_ref" => "required"
        ]);
        $user_id = auth('sanctum')->user()->id;
        $amount = $request->get("amount");
        if(!NewCustomer::where("user_id",  $user_id)->exists())
            return $utils->message("error", "User Not Found", 404);

        $customer_id =  NewCustomer::where("id",  $user_id)->value("id");


        $wallet = NewCustomer::where("user_id",  $user_id)->value("wallet");

        if(!NewCustomer::where("user_id", $user_id)->exists())
            return  $utils->message("success", "User Not Found", 404);

        $amount_bt = NewCustomer::where("user_id", $user_id)->value("wallet");
        $amount_at = $amount + $amount_bt;
        Log::info("######### Funds added #########", [
            "user_id" => $user_id,
            "customer_id" => $customer_id,
            "amount" => $amount,
            "amount_bt" => $amount_bt,
            "amount_at" => $amount_at
        ]);
        return  DB::transaction(function () use ($request, $utils,  $user_id, $amount, $amount_at, $amount_bt){

            try {
                $customer = NewCustomer::lockForUpdate()->where("user_id", $user_id)->firstOrFail();
                $customer->wallet = bcadd($customer->wallet, $amount, 9);
                $customer->update();

                $transactionHistory = new CustomerTransactionHistory;
                $transactionHistory->user_id = $user_id;
                $transactionHistory->customer_id = NewCustomer::where("user_id", $user_id)->value("id");
                $transactionHistory->amount = $amount;
                $transactionHistory->amount_at = $amount_at;
                $transactionHistory->amount_bt = $amount_bt;
                $transactionHistory->transaction_ref = $request->get("trx_ref");
                $transactionHistory->transaction_type = "Credit";
                $transactionHistory->payment_method = "Card";
                $transactionHistory->description = $request->get("amount") . " Fund Added By " . NewCustomer::where("user_id", $user_id)->value("first_name");
                $transactionHistory->save();
                return  $utils->message("success", "Fund Added Successfully.", 200);


            } catch (\GuzzleHttp\Exception\ClientException $e) {
                DB::rollBack();
                return $utils->message("error", $e->getMessage() , 400);
            }
        });
    }

}
