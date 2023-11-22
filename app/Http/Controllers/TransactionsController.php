<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddFundResource;
use App\Http\Resources\WithdrawalResource;
use App\Models\BankAccount;
use App\Models\CustomerTransactionHistory;
use App\Models\NewCustomer;
use App\Models\Withdrawals;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/admin/customer/get-history",
     *     summary="List all the transactions",
     *     tags={"Admin"},
     *     @OA\Response(response="200", description="List all the transactions"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getAllTransactionHistory(Request $request, Utils $utils): JsonResponse
    {
        $transaction_history =  AddFundResource::collection(CustomerTransactionHistory::with(["users", "customers"])->get());
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
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="User IDr",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="List debit transactions"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getTransactionDebitHistory(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "user_id" => "required|integer"
        ]);

        $transaction_history = CustomerTransactionHistory::where("user_id", $request->get("user_id"))->get();
        return  $utils->message("success", $transaction_history, 200);
    }

    /**
     * @OA\Get (
     *     path="/api/v1/customer/get-credit-history",
     *      tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="user_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *     @OA\Response(response="200", description="Registration successful", @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getTransactionCreditHistory(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "user_id" => "required|integer"
        ]);

        $transaction_history = CustomerTransactionHistory::where("user_id", $request->get("user_id"))->where("transaction_type", "Credit")->get();
        return  $utils->message("success", $transaction_history, 200);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/customer/get-history",
     *     summary="List Credit transactions",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="List transactions",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="List transactions"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getTransactionHistory(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "user_id" => "required|integer"
        ]);

        $transaction_history = CustomerTransactionHistory::where("id", $request->get("user_id"))->get();
        return  $utils->message("success", $transaction_history, 200);
    }


    /**
     * @OA\Post (
     *     path="/api/v1/customer/withdrawal",
     *     summary="Add Fund",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="id of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="amount",
     *         in="query",
     *         description="Amount",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Withdraw Funds"),
     *     @OA\Response(response="500", description="Internal Server Error")
     * )
     */
    public function withdrawal(Request $request, Utils $utils): JsonResponse
    {
        $user_id =  $request->get("user_id");
        $amount = $request->get("amount");
        $total = 0;
        $balance = NewCustomer::where("user_id", $user_id)->value("wallet");
        if ($amount >= $balance)
            return  $utils->message("error", "Insufficient Balance.", 400);

        try {
            $balance = NewCustomer::where("user_id", $user_id)->value("wallet");
            $total = $balance - $amount;

            return  DB::transaction(function () use ($request, $total, $utils, $amount, $user_id){
                    NewCustomer::where("user_id", $user_id)->update(["wallet" => $total]);

                    $transactionHistory = new Withdrawals();
                    $transactionHistory->user_id = $user_id;
                    $transactionHistory->customer_id = NewCustomer::where("user_id", $user_id)->value("id");
                    $transactionHistory->bank_account_id = BankAccount::where("user_id", $user_id)->value("id");
                    $transactionHistory->amount = $amount;
                    $transactionHistory->trx_ref =  "9ja_" .  Str::random(15);
                    $transactionHistory->status = "Pending";
                    $transactionHistory->narration = "Withdrawal from " . NewCustomer::where("user_id", $user_id)->value("first_name");
                    $transactionHistory->save();
                   return $utils->message("success", "Your Withdrawal will be reviewed within 24hrs", 200);
                });
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $utils->message("error", $e->getMessage() , 400);
        }
    }


    /**
     * @OA\Post (
     *     path="/api/v1/customer/add-fund",
     *     summary="Add Fund",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="id of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
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
     *     @OA\Response(response="200", description="Add Fund"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function addFund(Request $request, Utils $utils)
    {
        $request->validate([
            "user_id" => "required",
            "amount" => "required",
            "trx_ref" => "required"
        ]);
        if(!NewCustomer::where("user_id",  $request->get("user_id"))->exists())
            return $utils->message("error", "User Not Found", 404);

        $customer_id =  NewCustomer::where("id",  $request->get("user_id"))->value("id");


        $wallet = NewCustomer::where("user_id",  $request->get("user_id"))->value("wallet");
        $total = $wallet + $request->get("amount");

        if(!NewCustomer::where("user_id", $request->get("user_id"))->exists())
            return  $utils->message("success", "User Not Found", 404);

        $customer = NewCustomer::where("user_id", $request->get("user_id"))->firstOrFail();
        $customer->wallet = $total;
        $customer->update();

        $transactionHistory = new CustomerTransactionHistory;
        $transactionHistory->user_id = $request->get("user_id");
        $transactionHistory->customer_id = NewCustomer::where("user_id", $request->get("user_id"))->value("id");
        $transactionHistory->amount = $request->get("amount");
        $transactionHistory->transaction_ref = $request->get("trx_ref");
        $transactionHistory->transaction_type = "Credit";
        $transactionHistory->payment_method = "Card";
        $transactionHistory->description = "Fund Added By" . NewCustomer::where("user_id", $request->get("user_id"))->value("first_name");
        $transactionHistory->save();
        return  $utils->message("success", "Fund Added Successfully.", 200);

    }

}
