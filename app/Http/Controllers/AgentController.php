<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgentDashboard;
use App\Http\Resources\AgentPaymentResource;
use App\Http\Resources\AgentStakeResource;
use App\Http\Resources\AgentTransactionHistoryResource;
use App\Http\Resources\CreatePaymentResource;
use App\Http\Resources\StakeAgentPlatformResource;
use App\Http\Resources\StakeResource;
use App\Http\Resources\WinningTags;
use App\Models\Agent;
use App\Models\AgentFundingTransactions;
use App\Models\AgentPayments;
use App\Models\AgentStakes;
use App\Models\AgentTransactionHistory;
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
use GuzzleHttp\Promise\Create;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AgentController extends Controller
{

    public function getDashboardData(Request $request, Utils $utils)
    {
        $user_id = auth('sanctum')->user()->id;

        $todayStakes = AgentStakes::whereDate("created_at", Carbon::today())->where("user_id", $user_id)->sum("stake_price");
        $noOfTodayStakes = AgentStakes::whereDate("created_at", Carbon::today())->where("user_id", $user_id)->count("stake_price");
        $stakes = Stake::sum("stake_price");
        $transactions = AgentTransactionHistory::where("user_id", $user_id)->sum("amount");
        $data = [
          "todayStake" => $todayStakes,
          "stakes" => $stakes,
          "noOfTodayStakes" => $noOfTodayStakes,
          "transactions" => $transactions
        ];
        return  $utils->message("success", $data, 200);

    }

    /**
     * @OA\Get(
     *     path="/api/v1/agent/get-transactions",
     *     summary="get Transactions",
     *     tags={"Agent"},
     *     @OA\Response(response="200", description="Get category id", @OA\JsonContent()),
     * )
     */
    public function getTransactions(Request $request, Utils $utils)
    {
        $user_id = auth('sanctum')->user()->id;
      return  $utils->message("success", AgentTransactionHistoryResource::collection(AgentTransactionHistory::where("user_id", $user_id)->get()), 200);

    }
    /**
     * @OA\Get(
     *     path="/api/v1/agent/get-raffle-status",
     *     summary="Get Machines",
     *     tags={"Agent"},
     *     @OA\Response(response="200", description="Get category id", @OA\JsonContent()),
     * )
     */
    public function getRaffleStatus($id, Request $request, Utils $utils)
    {

        if (!Stake::where("ticket_id", $id)->exists())
            return  $utils->message("error", "Ticket ID Does Not Exist", 404);

        $status = Stake::where("ticket_id", $id)->get(["win"]);
        return  $utils->message("success", $status, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/agent/all-highest-number",
     *     summary="Get Machines",
     *     tags={"Agent"},
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
     *     tags={"Agent"},
     *     @OA\Parameter(
     *         name="agent_id",
     *         in="query",
     *         description="id of the agent",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get Dashboard Items", @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function allStakes(Request $request, Utils $utils)
    {
        $user_id = auth('sanctum')->user()->id;
        $agent_id = Agent::where("user_id", $user_id)->value("id");
        $agentStakes =  AgentStakes::where("agent_id", $agent_id)->with("winningTags")->orderBy("created_at", "DESC")->get();
        return  $utils->message("success", AgentStakeResource::collection($agentStakes), 200);
    }
    /**
     * @OA\Get(
     *     path="/api/v1/agent/today-stakes",
     *     summary="Get Today Stake",
     *     tags={"Agent"},
     *     @OA\Response(response="200", description="Get Dashboard Items", @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials", @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function todayStakes(Request $request, Utils $utils)
    {
        $user_id = auth('sanctum')->user()->id;
        $agent_id = Agent::where("user_id", $user_id)->value("id");
        $agentStakes =  AgentStakes::where("agent_id", $agent_id)->with("winningTags")->whereDate("created_at", Carbon::today())->orderBy("created_at", "DESC")->get();
        return  $utils->message("success", AgentStakeResource::collection($agentStakes), 200);
    }
    public function store(Request $request, Utils $utils)
    {
//        return Carbon::now();
        $user_id = auth('sanctum')->user()->id;

        $request->validate([
            'raffle_number' => 'required|max:191',
        ]);
        $stake_number = $request->get("raffle_number");
        $stake_platform_id = $request->get("raffleId");

        if(StakePlatform::where("platform_ref", $stake_platform_id)->value("is_open") == 0 && StakePlatform::where("platform_ref", $stake_platform_id)->value("is_close") == 1)
            return $utils->message("error", "Raffle is closed", 422);


        if(StakePlatform::where("platform_ref",$stake_platform_id)->where("start_date", ">", \Carbon\Carbon::now())->exists())
            return $utils->message("error", "Raffle is not open yet", 422);

        if (!User::where("id", $user_id)->exists())
            return $utils->message("error", "User Does not Exist", 404);

        $win_number = StakePlatform::where("platform_ref",$stake_platform_id)->value("win_nos");
        $maxWinnerCountFromDB = StakePlatform::where("platform_ref", $stake_platform_id)->value("max_winner_count");
        $countWinners = StakePlatform::where("platform_ref", $stake_platform_id)->value("count_winners");
        $winNoFromDB = StakePlatform::where("platform_ref", $stake_platform_id)->value("win_nos");

        if ($maxWinnerCountFromDB == $countWinners && $winNoFromDB == $stake_number)
            return $utils->message("error", "Number is Not Available", 422);


        if($win_number == $stake_number){
            $win = 1;
            $stake_platform = StakePlatform::where("platform_ref", $stake_platform_id)->firstOrFail();
            $stake_platform->count_winners += 1;
            $stake_platform->update();
        } else{
            $win = 0;
        }
        if(!Agent::where("user_id", $user_id)->exists())
            return $utils->message("error", "User Not Found", 404);

        $agent_balance = Agent::where("user_id", $user_id)->value("wallet");
        $price = StakePlatform::where("platform_ref", $stake_platform_id)->value("stake_price");

        if ($agent_balance >= $price){
            $balance = bcsub($agent_balance, $price, 9);
            $customer = Agent::where("user_id", $user_id)->firstOrFail();
            $customer->wallet = $balance;
            $customer->update();
        }else{
            return $utils->message("error", "Insufficient Balance", 422);
        }

        $ticket_id = Str::random(10);
        if (Stake::where("ticket_id", $ticket_id)->exists())
            return $utils->message("error", "Network Error. Please Try again", 500);

        return  DB::transaction(function () use ($request, $stake_number, $utils, $ticket_id, $user_id, $price, $stake_platform_id) {
            try {

                $platform_id = StakePlatform::where("platform_ref", $stake_platform_id)->value("id");
                $agent_id = Agent::where("user_id", $user_id)->value("id");

                Log::info("############# Agent Stake ###############", [
                    "user_id" => $user_id,
                    "ticket_id" => $ticket_id,
                    "price" => $price,
                    "stake_platform_id" => $stake_platform_id,
                    "stake_number" => $stake_number,
                    "agent_id" => $agent_id
                ]);

                $stake = new AgentStakes();
                $stake->user_id = $user_id;
                $stake->agent_id = $agent_id;
                $stake->ticket_id = $ticket_id;
                $stake->stake_price = $price;
                $stake->stake_number = $stake_number;
                $stake->win = 0;
                $stake->active = 1;
                $stake->role = "Agent";
                $stake->month = StakePlatform::where("platform_ref", $stake_platform_id)->value("month");
                $stake->year = StakePlatform::where("platform_ref", $stake_platform_id)->value("year");
                $stake->winning_tags_id = StakePlatform::where("platform_ref", $stake_platform_id)->value("winning_tags_id");
                $stake->category_id = StakePlatform::where("platform_ref", $stake_platform_id)->value("category_id");
                $stake->stake_platform_id = $platform_id;
                $stake->save();


                $transactionHistory = new AgentTransactionHistory();
                $transactionHistory->user_id = $user_id;
                $transactionHistory->agent_id = $agent_id;
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
                    "created_at" => Carbon::parse($stake->created_at)->format("d M, Y"),
                    "address" => Agent::where("user_id", $user_id)->value("address"),
                    "wallet" => number_format(Agent::where("user_id", $user_id)->value("wallet"), 2)
                ];
                return $utils->message("success", $data, 200);

            } catch (\GuzzleHttp\Exception\ClientException $e) {
                return $utils->message("error", $e->getMessage(), 400);
            }
        });
    }

    public function successfulPayment(Request $request, Utils $utils)
    {

        $request->validate([
            "tx_ref" => "required|string",
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


                $agent = Agent::lockForUpdate()->where("user_id", $user_id)->firstOrFail();
                $agent->wallet += $amount;
                $agent->update();

                $funding = AgentFundingTransactions::lockForUpdate()->where("company_ref", $request->get("tx_ref"))->firstOrFail();
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

                $agentTransaction = new AgentTransactionHistory();
                $agentTransaction->user_id = $user_id;
                $agentTransaction->agent_id = $agent_id;
                $agentTransaction->amount = $amount;
                $agentTransaction->transaction_type = "credit";
                $agentTransaction->transaction_ref = $request->get("tx_ref");
                $agentTransaction->role = "Agent";
                $agentTransaction->description = "Funded Wallet with " . $amount;
                $agentTransaction->save();

                return $utils->message("success", "Payment Completed Successfully.", 200);

            } catch (\Throwable $e) {
                Log::error("########## Error Message #########");
                return $utils->message("error", $e->getMessage(), 404);
            }
        });
    }
    public function updatePayment(Request $request, Utils $utils)
    {
        $id = $request->get("id");
        return  DB::transaction(function () use ($request, $utils, $id) {
            try {


                if(AgentFundingTransactions::where("id",$id)->value('status') !== "Completed"){
                    Log::info("########## Updating Cancelled Status  #########");
                    $payment = AgentFundingTransactions::lockForUpdate()->where("company_ref", $id)->firstOrFail();
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
    public function createPayment(Request $request, Utils $utils)
    {
        $request->validate([
            "amount" => "required|int",
            "status" => "required|string",
            "ref" => "required|string"
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

                return $utils->message("success", new CreatePaymentResource($payment), 200);

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
         if (!$utils->validatePin($request, $pinFromDB))
            return   $utils->message("error", "Invalid Pin", 422);

      return  $utils->message("success", "Pin Validation Successful", 200);

    }


    public function getRaffles(Request $request, Utils $utils)
    {
        $user_id = auth('sanctum')->user()->id;
        $stakes =  DB::table('customers_stakes')
            ->join('winning_tags', 'winning_tags.id', '=', 'customers_stakes.winning_tags_id')
            ->join('stake_platforms', 'stake_platforms.id', '=', 'customers_stakes.stake_platform_id')
            ->where('customers_stakes.user_id', '=', $user_id)
            ->select("stake_platforms.created_at", "stake_platforms.is_close","winning_tags.name as winningTags", "customers_stakes.id as key", "customers_stakes.stake_price as stakePrice", "customers_stakes.created_at as date", "customers_stakes.stake_number as  numberPicked")
            ->orderBy("stake_platforms.created_at", "DESC")
            ->get();

        $data = [
            "stakes" => $stakes,
            "total" => 0
        ];

        return $utils->message("success", $data, 200);
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
