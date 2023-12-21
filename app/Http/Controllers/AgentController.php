<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgentPaymentResource;
use App\Models\Agent;
use App\Models\AgentFundingTransactions;
use App\Models\AgentPayments;
use App\Models\StakePlatform;
use App\Utils\ConstantValues\ConstantValues;
use App\Utils\Utils;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller
{

    public function successfulPayment(Request $request, Utils $utils)
    {

        $request->validate([
            "id" => "required|int",
            "amount" => "required|int"
        ]);
        $user_id = auth('sanctum')->user()->id;
        Log::info("########## Checking If User Exists #########");
        if(!Agent::where("user_id", $user_id)->exists())
            return  $utils->message("error", "Agent Not Found", 404);


        return  DB::transaction(function () use ($request, $utils, $user_id) {
            try {

                $amount = $request->get("amount");
                Log::info("########## Getting Balance Value #########");
                $balance = Agent::where("user_id", $user_id)->value("wallet");
                $total = $balance + $amount;

                $agent_id = Agent::where("user_id", $user_id)->value("id");


                $firstName = Agent::where("user_id", $user_id)->value("first_name");
                $lastName = Agent::where("user_id", $user_id)->value("last_name");
                $narration = $firstName . " " . $lastName . " Funded Account";

                Log::info("########## Adding Amount to Agent Wallet #########", [
                    "AmountBeforeAddition" => $balance,
                    "AmountAfterAddition" => $total,
                ]);
                Log::info("########## Response from Flutterwave #########", json_decode( json_encode($request->all()) , true));


                $agent = Agent::where("user_id", $user_id)->firstOrFail();
                $agent->wallet += $amount;
                $agent->update();

                $funding = AgentFundingTransactions::find($request->get("id"));
                $funding->narration = $narration;
                $funding->balance_ba = $balance;
                $funding->balance_aa = $total;
                $funding->amount = $amount;
                $funding->user_id = $user_id;
                $funding->agent_id = $agent_id;
                $funding->trx_ref = $request->get("tx_ref");
                $funding->status = "Completed";
                $funding->charge_response_code = $request->get("charge_response_code");
                $funding->transaction_id = $request->get("transaction_id");
                $funding->flw_ref = $request->get("flw_ref");
                $funding->update();
                return $utils->message("success", "Payment Completed Successfully.", 200);

            } catch (\Throwable $e) {
                Log::error("########## Error Message #########");
                return $utils->message("error", $e->getMessage(), 404);
            }
        });
    }
    public function updatePayment(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "id" => "required|int"
        ]);
        return  DB::transaction(function () use ($request, $utils) {
            try {

                if(AgentFundingTransactions::where("id", $request->get("id"))->value('status') !== "Completed"){
                    Log::info("########## Updating Cancelled Status  #########");
                    $payment = AgentFundingTransactions::where("id", $request->get("id"))->firstOrFail();
                    $payment->status = $request->get("status");
                    $payment->update();
                    Log::info("########## Payment Status changed from Pending to Cancelled #########");
                }

                return $utils->message("success", "Saved Successfully.", 200);

            } catch (\Throwable $e) {
                Log::error("########## Error Message #########");
                return $utils->message("error", $e->getMessage(), 404);
            }
        });

    }
    public function createPayment(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "amount" => "required|int",
            "status" => "required|string"
        ]);
        return  DB::transaction(function () use ($request, $utils) {
            try {

                Log::info("########## Initialize Payment #########");

                $user_id = auth('sanctum')->user()->id;
                $agent_id = Agent::where("user_id", $user_id)->value("id");
                $payment = new AgentFundingTransactions();
                $payment->amount = $request->get("amount") ;
                $payment->company_ref = $request->get("ref") ;
                $payment->status = $request->get("status");
                $payment->user_id = $user_id;
                $payment->agent_id = $agent_id;
                $payment->save();

                Log::info("########## Payment Initialization Data #########", json_decode($payment, true));
                Log::info("########## Payment Initialization Saved #########");

                return $utils->message("success", new AgentPaymentResource($payment), 200);

            } catch (\Throwable $e) {
                Log::error("########## Error Message #########");
                return $utils->message("error", $e->getMessage(), 404);
            }
        });

    }
    public function checkBalance(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "amount" => "required|int"
        ]);
        $user_id = auth('sanctum')->user()->id;
            if (!$utils->checkBalance("agent", $user_id, $request))
            return   $utils->message("error", "Insufficient Balance", 401);
        return  $utils->message("success", "Balance Validated Successful", 200);


    }
    public function validatePin(Request $request, Utils $utils)
    {
        $request->validate([
            "pin" => "required|int"
        ]);
         $pinFromDB = auth('sanctum')->user()->pin;
         if (!$utils->validatePin($request, $pinFromDB, $utils))
            return   $utils->message("error", "Invalid Pin", 401);

      return  $utils->message("success", "Pin Validation Successful", 200);

    }
    public function getRaffles(Utils $utils)
    {
        $stakes =  DB::table('customers_stakes')
            ->join('winning_tags', 'winning_tags.id', '=', 'customers_stakes.winning_tags_id')
            ->join('categories', 'categories.id', '=', 'customers_stakes.category_id')
            ->join('stake_platforms', 'stake_platforms.id', '=', 'customers_stakes.stake_platform_id')
            ->where('stake_platforms.is_close', '=', 1)
            ->limit(10)
            ->select("winning_tags.name as winningTags", "customers_stakes.id as key", "customers_stakes.stake_price as stakePrice", "customers_stakes.created_at as date", "customers_stakes.stake_number as  numberPicked")
            ->get();

        return $utils->message("success", $stakes, 200);
    }
}
