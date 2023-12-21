<?php

namespace App\Http\Controllers;

use App\Http\Resources\BankResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\ProfileResource;
use App\Models\BankAccount;
use App\Models\Banks;
use App\Models\CustomerTransactionHistory;
use App\Models\NewCustomer;
use App\Models\Stake;
use App\Models\User;
use App\Models\Withdrawals;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/get-banks",
     *     summary="Get all Banks",
     *     tags={"General"},
     *     @OA\Response(response="200", description="Get all Bank Accounts"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getBanks(Utils $utils): JsonResponse
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env("FLUTTERWAVE_SEC_KEY") ,
        ];
//        try {
//            $client = new \GuzzleHttp\Client();
//            $response = $client->request('GET', 'https://api.flutterwave.com/v3/banks/NG' , [
//                'verify' => false,
//                'headers' => $headers
//            ]);
//            $banks = json_decode($response->getBody(), true);
//
//            foreach ($banks["data"] as $bank){
//                $banking = new Banks();
//                $banking->code = json_decode(json_encode($bank["code"]));
//                $banking->name = json_decode(json_encode($bank["name"]));
//                $banking->save();
//            }
//            return $utils->message("success", json_decode(json_encode($banks["data"]))  , 200);
//
//        }catch (\Throwable $e) {
//            // Do something with your exception
//            return $utils->message("error",$e->getMessage()  , 400);
//        }

        $banks =  Banks::all();
        return $utils->message("success", $banks, 200);
    }
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
        $accountDetails = User::where("id", $request->get("user_id"))->with(["profile", "bankAccount"])->firstOrFail();
        $sum = CustomerTransactionHistory::where("user_id", $request->get("user_id"))->where("transaction_type", "Credit")->sum("amount");
        $sums = Withdrawals::where("user_id", $request->get("user_id"))->sum("amount");
        $stakeSum = Stake::where("user_id", $request->get("user_id"))->sum("stake_price");
        $winSum = Stake::where("user_id", $request->get("user_id"))->where("win", 1)->sum("stake_price");

        $data = [
            "total_fund_added" => doubleval($sum),
            "total_stake" => doubleval($stakeSum),
            "total_win" => doubleval($winSum),
            "account_details" => new ProfileResource($accountDetails),
            "total_fund_withdrawn" => doubleval($sums)
        ];
        return  $utils->message("success", $data, 200);
    }
    public function store(Request $request, Utils $utils)
    {
        $request->validate([
            "account_name" => "required|string",
            "account_no" => "required|integer",
            "bank" => "required|string",
            "user_id" => "required|integer"
        ]);
        if(BankAccount::where("user_id", $request->get("user_id"))->exists())
            return  $utils->message("error", "Account already Exists", 400);

        $bank = Banks::where("code", $request->get("bank"))->value("name");
         $bankAccount = new BankAccount();
         $bankAccount->user_id = $request->get("user_id");
         $bankAccount->account_no = $request->get("account_no");
         $bankAccount->bank_code = $request->get("bank");
         $bankAccount->bank = $bank;
         $bankAccount->save();

        return  $utils->message("success", "Account Details Uploaded Successfully.", 200);

    }
}
