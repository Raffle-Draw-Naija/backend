<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\CustomerTransactionHistory;
use App\Models\NewCustomer;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/admin/bank-accounts/all",
     *     summary="Get all Bank Accounts",
     *     tags={"Admin"},
     *     @OA\Response(response="200", description="Get all Bank Accounts"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getAllAccounts(Request $request, Utils $utils): JsonResponse
    {

        $accounts = BankAccount::all();
        return  $utils->message("success", $accounts, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/customer/account",
     *     summary="Get all Bank Accounts",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="id of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get all Bank Accounts"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getAccountDetails(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "user_id" => "required|integer"
        ]);
        $accountDetails = BankAccount::where("user_id", $request->get("user_id"))->firstOrFail();
        return  $utils->message("success", $accountDetails, 200);
    }
    /**
     * @OA\Post(
     *     path="/api/v1/customer/account/create",
     *     summary="Add User Bank Account",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="id of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="account_name",
     *         in="query",
     *         description="Account Name of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="account_no",
     *         in="query",
     *         description="Account No of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="bank",
     *         in="query",
     *         description="bank of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Add User Bank Account"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
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
