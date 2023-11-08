<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddFundResource;
use App\Models\CustomerTransactionHistory;
use App\Models\NewCustomer;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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


    /**
     * @OA\Post(
     *     path="/api/v1/customer/get-transaction-history",
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


    public function getTransactionCreditHistory(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "user_id" => "required|integer"
        ]);

        $transaction_history = CustomerTransactionHistory::where("id", $request->get("user_id"))->where("transaction_type", "Credit")->get();
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
     * @OA\Get(
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
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="description",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Add Fund"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function addFund(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "user_id" => "required",
            "amount" => "required",
            "trx_ref" => "required"
        ]);
        if(!NewCustomer::where("user_id",  $request->get("user_id"))->exists())
            return $utils->message("error", "User Not Found", 404);

        $customer_id =  NewCustomer::where("id",  $request->get("user_id"))->value("id");


        $wallet = NewCustomer::where("id",  $request->get("user_id"))->value("wallet");
        $balance = $wallet + $request->get("amount");

        if(!NewCustomer::where("user_id", $request->get("user_id"))->exists())
            return  $utils->message("success", "User Not Found", 404);

        $customer = NewCustomer::where("user_id", $request->get("user_id"))->firstOrFail();
        $customer->wallet = $balance;
        $customer->update();

        $transactionHistory = new CustomerTransactionHistory;
        $transactionHistory->user_id = $request->get("user_id");
        $transactionHistory->amount = $request->get("amount");
        $transactionHistory->transaction_ref = $request->get("trx_ref");
        $transactionHistory->transaction_type = "Credit";
        $transactionHistory->payment_method = "Card";
        $transactionHistory->description = $request->get("description");
        $transactionHistory->save();
        return  $utils->message("success", "Fund Added Successfully.", 200);

    }

}
