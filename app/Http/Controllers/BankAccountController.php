<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\CustomerTransactionHistory;
use App\Models\NewCustomer;
use App\Models\User;
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
     *     path="/api/v1/customer/profile",
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
    public function getProfile(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "user_id" => "required|integer"
        ]);
        $accountDetails = User::where("id", $request->get("user_id"))->with("profile")->firstOrFail();
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
