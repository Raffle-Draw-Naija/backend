<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgentPaymentResource;
use App\Http\Resources\StakeResource;
use App\Http\Resources\WinningTags;
use App\Models\Agent;
use App\Models\AgentFundingTransactions;
use App\Models\AgentPayments;
use App\Models\CustomerTransactionHistory;
use App\Models\NewCustomer;
use App\Models\Stake;
use App\Models\StakePlatform;
use App\Models\User;
use App\Models\WinNumbers;
use App\Utils\ConstantValues\ConstantValues;
use App\Utils\Utils;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AgentController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/v1/agent/get-raffle-status",
     *     summary="Get Machines",
     *     tags={"General"},
     *     @OA\Response(response="200", description="Get category id", @OA\JsonContent()),
     * )
     */
    public function getRaffleStatus(Request $request, Utils $utils)
    {
        $request->validate([
            "ticket_id" => "required"
        ]);

        $status = Stake::where("ticket_id", $request->get("ticket_id"))->value("win");
        if ($status == 0)
            $status = "Winner";
        else
            $status = "Loser";

        $data = [
            "status" => $status
        ];
        $utils->message("success", $status, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/agent/all-highest-number",
     *     summary="Get Machines",
     *     tags={"General"},
     *     @OA\Response(response="200", description="Get category id", @OA\JsonContent()),
     * )
     */
    public function getHighestNumber(Utils $utils)
    {
        $utils->message("success",WinNumbers::orderBy("created_at", "DESC")->limit(1)->get(), 200);

    }
    /**
     * @OA\Get(
     *     path="/api/v1/agent/all-stakes",
     *     summary="Get Machines",
     *     tags={"General"},
     *     @OA\Parameter(
     *         name="agent_id",
     *         in="query",
     *         description="id of the agent",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get category id", @OA\JsonContent()),
     * )
     */
    public function allStakes(Request $request, Utils $utils)
    {
        $agent_di = $request->get("agent_id");
        $utils->message("success", StakeResource::collection(Stake::where("id", $agent_di)->with("WinningTags")->get()), 200);
    }
    public function store(Request $request, Utils $utils)
    {
//        return Carbon::now();

        $request->validate([
            'user_id' => 'required|max:191',
            'raffle_number' => 'required|max:191',
            'raffleId' => 'required|max:191',
        ]);
        $stake_number = $request->get("raffle_number");
        $user_id = $request->get("user_id");
        $stake_platform_id = $request->get("raffleId");

        if(StakePlatform::where("id", $stake_platform_id)->value("is_open") == 0 && StakePlatform::where("id", $stake_platform_id)->value("is_close") == 1)
            return $utils->message("error", "Raffle is closed", 422);


        if(StakePlatform::where("id",$stake_platform_id)->where("start_date", ">", \Carbon\Carbon::now())->exists())
            return $utils->message("error", "Raffle is not open yet", 422);

        if (!User::where("id", $user_id)->exists())
            return $utils->message("error", "User Does not Exist", 404);

        $win_number = StakePlatform::where("id", $request->get("stake_platform_id"))->value("win_nos");

        if($win_number == $stake_number){
            $win = 1;
            $stake_platform = StakePlatform::findOrFail($request->get("stake_platform_id"));
            $stake_platform->count_winners += 1;
            $stake_platform->update();
        } else{
            $win = 0;
        }
        if(!Agent::where("user_id", $user_id)->exists())
            return $utils->message("error", "User Not Found", 404);

        $agent_balance = Agent::where("user_id", $user_id)->value("wallet");
        $price = StakePlatform::where("id", $stake_platform_id)->value("stake_price");

        if ($agent_balance >= $price){
            $balance = $agent_balance - $price;
            $customer = Agent::where("user_id", $user_id)->firstOrFail();
            $customer->wallet = $balance;
            $customer->update();
        }else{
            return $utils->message("error", "Insufficient Balance", 422);
        }

        $ticket_id = Str::random(10);
        if (Stake::where("ticket_id", $ticket_id)->exists())
            return $utils->message("error", "Network Error. Please Try again", 500);

        $agent_id = Agent::where("user_id", $user_id)->value("id") ;;
        $stake = new Stake;
        $stake->user_id = $user_id;
        $stake->customer_id = $agent_id;
        $stake->ticket_id = $ticket_id;
        $stake->stake_price = $price;
        $stake->stake_number = $stake_number;
        $stake->win = $win;
        $stake->active = 1;
        $stake->role = "Agent";
        $stake->month = StakePlatform::where("id", $stake_platform_id)->value("month") ;
        $stake->year = StakePlatform::where("id", $stake_platform_id)->value("year") ;
        $stake->winning_tags_id = StakePlatform::where("id", $stake_platform_id)->value("winning_tags_id") ;
        $stake->category_id = StakePlatform::where("id", $stake_platform_id)->value("category_id") ;
        $stake->stake_platform_id = $stake_platform_id;
        $stake->save();


        $transactionHistory = new CustomerTransactionHistory;
        $transactionHistory->user_id = $user_id;
        $transactionHistory->customer_id = $agent_id;
        $transactionHistory->amount = $price;
        $transactionHistory->transaction_type = "Debit";
        $transactionHistory->description = "Payment for ticket " . $ticket_id;
        $transactionHistory->transaction_ref = Str::random(10);
        $transactionHistory->role = "Agent";
        $transactionHistory->save();

        $data = [
            "winningTag" => \App\Models\WinningTags::where("id", $stake->winning_tags_id)->value("name"),
            "stake_price" => $stake->stake_price,
            "ticket_id" => $stake->ticket_id,
            "created_at" => Carbon::parse($stake->created_at)->format("d M, Y")
        ];
        return $utils->message("success", $data, 200);

    }

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

        return $utils->message("success", StakeResource::collection($stakes), 200);
    }
    /**
     * @OA\Get  (
     *     path="/api/v1/agent/get-raffle",
     *     summary="Get Withdrawal",
     *     tags={"Agent"},
     *     @OA\Parameter(
     *         name="agent_id",
     *         in="query",
     *         description="id of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Getting withdrawal Sucessful", @OA\JsonContent()),
     *     @OA\Response(response="400", description="Bad Request", @OA\JsonContent()),
     *     @OA\Response(response="404", description="User Not Found", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     * )
     */
    public function getAgentRaffles(Request $request, Utils $utils)
    {
        $request->validate([
            "agent_id" => "required"
        ]);

        $agent_id = $request->get("agent_id");
        $stakes =  DB::table('customers_stakes')
            ->join('winning_tags', 'winning_tags.id', '=', 'customers_stakes.winning_tags_id')
            ->join('categories', 'categories.id', '=', 'customers_stakes.category_id')
            ->join('stake_platforms', 'stake_platforms.id', '=', 'customers_stakes.stake_platform_id')
            ->where('stake_platforms.is_close', '=', 1)
            ->where('customers_stakes.user_id', '=', $agent_id)
            ->limit(10)
            ->select("winning_tags.name as winningTags", "customers_stakes.id as key", "customers_stakes.stake_price as stakePrice", "customers_stakes.created_at as date", "customers_stakes.stake_number as  numberPicked")
            ->get();

        return $utils->message("success", $stakes, 200);
    }
}
