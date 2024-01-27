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
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/customer/account",
     *     summary="Get all Bank Accounts",
     *     tags={"Mobile"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Get all Bank Accounts"),
     *     @OA\Response(response="401", description="Invalid credentials"),
     *     @OA\Response(response="404", description="Page Not Found")
     * )
     */
    public function getAccount(Request $request, Utils $utils)
    {
        $user_id =  auth('sanctum')->user()->id;
        if (BankAccount::where("user_id",$user_id)->exists())
            return  $utils->message("error", "Account Not Found", 404);

        $bankAccount = BankAccount::where("user_id", $user_id)->firstOrFail();
        $data = [
            "account" => $bankAccount,
            "accountCreated" => 1
        ];
        return  $utils->message("success", $data, 200);

    }
    /**
     * @OA\Get(
     *     path="/api/v1/get-banks",
     *     summary="Get all Banks",
     *     tags={"General"},
     *     security={
     *         {"sanctum": {}}
     *     },
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
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Get all Bank Accounts"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getProfile(Request $request, Utils $utils): JsonResponse
    {
        $user_id =  auth('sanctum')->user()->id;
        $accountDetails = User::where("id", $user_id)->with(["profile", "bankAccount"])->firstOrFail();
        $sum = CustomerTransactionHistory::where("user_id", $user_id)->where("transaction_type", "Credit")->sum("amount");
        $sums = Withdrawals::where("user_id", $user_id)->sum("amount");
        $stakeSum = Stake::where("user_id", $user_id)->sum("stake_price");
        $winSum = Stake::where("user_id", $user_id)->where("win", 1)->sum("stake_price");

        $data = [
            "total_fund_added" => doubleval($sum),
            "total_stake" => doubleval($stakeSum),
            "total_win" => doubleval($winSum),
            "account_details" => new ProfileResource($accountDetails),
            "total_fund_withdrawn" => doubleval($sums)
        ];
        return  $utils->message("success", $data, 200);
    }


    /**
     * @OA\Post (
     *     path="/api/v1/customer/account/create",
     *      tags={"Mobile"},
     *     @OA\Parameter(
     *         name="account_name",
     *         in="query",
     *         description="account_name",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *     @OA\Parameter(
     *         name="account_number",
     *         in="query",
     *         description="account_number",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *     @OA\Parameter(
     *         name="bank_code",
     *         in="query",
     *         description="bank_code",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
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
     *     @OA\Response(response="200", description="Getting Stake successful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent()),
     *     @OA\Response(response="401", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function store(Request $request, Utils $utils)
    {
        $request->validate([
            "account_name" => "required|string",
            "account_number" => "required|digits:10",
            "bank_code" => "required|string"
        ]);
        $user_id =  auth('sanctum')->user()->id;
        if(BankAccount::where("user_id",$user_id)->exists())
            return  $utils->message("error", "Account already Exists", 400);

        return  DB::transaction(function () use ($request, $utils, $user_id){
            try {
                if (!Banks::where("code", $request->get("bank_code"))->exists())
                    return $utils->message("error","Bank Not Found" , 422);

                $bank = Banks::where("code", $request->get("bank_code"))->value("name");
                 $bankAccount = new BankAccount();
                 $bankAccount->user_id = $user_id;
                 $bankAccount->account_number = $request->get("account_number");
                 $bankAccount->bank_code = $request->get("bank_code");
                 $bankAccount->account_name = $request->get("account_name");
                 $bankAccount->bank = $bank;
                 $bankAccount->save();

                 $user = User::findOrFail($user_id);
                 $user->account_created = 1;
                 $user->update();
                 return  $utils->message("success", "Account Details Uploaded Successfully.", 200);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                return $utils->message("error", $e->getMessage() , 422);
            }
        });

    }
}
