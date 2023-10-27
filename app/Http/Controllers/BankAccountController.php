<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\CustomerTransactionHistory;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function getAllTransactionHistory(Request $request, Utils $utils): JsonResponse
    {

        $transaction_history = CustomerTransactionHistory::all();
        return  $utils->message("success", $transaction_history, 200);
    }
    public function getHistory(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "user_id" => "required|integer"
        ]);

        $transaction_history = CustomerTransactionHistory::where("id", $request->get("user_id"))->get();
        return  $utils->message("success", $transaction_history, 200);

    }
    public function getAllAccounts(Request $request, Utils $utils): JsonResponse
    {

        $accountDetails = BankAccount::all();
        return  $utils->message("success", $accountDetails, 200);
    }

    public function getAccount(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "user_id" => "required|integer"
        ]);
        $accountDetails = BankAccount::where("user_id", $request->get("user_id"))->firstOrFail();
        return  $utils->message("success", $accountDetails, 200);
    }
    public function store(Request $request, Utils $utils)
    {
        $request->validate([
            "account_name" => "required|string",
            "account_no" => "required|integer",
            "bank" => "required|string",
            "user_id" => "required|integer"
        ]);
        if(!BankAccount::where("user_id", $request->get("user_id"))->exists())
            return  $utils->message("error", "User Not Found", 404);
        return  $utils->message("success", "Account Details Uploaded Successfully.", 200);

    }
}
