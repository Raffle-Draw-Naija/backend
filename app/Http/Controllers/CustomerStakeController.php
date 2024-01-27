<?php

namespace App\Http\Controllers;

use App\Http\Resources\RaffleDrawsResource;
use App\Http\Resources\RaffleResource;
use App\Http\Resources\StakeResource;
use App\Http\Resources\WinningTagsResource;
use App\Models\Categories;
use App\Models\CustomerTransactionHistory;
use App\Models\NewCustomer;
use App\Models\StakePlatform;
use App\Models\User;
use App\Models\WinNumbers;
use App\Utils\Utils;
use App\Models\Stake;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\WinningTags;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class CustomerStakeController extends Controller
{

    /**
     * @OA\Get   (
     *     path="/api/v1/customer/get-raffles",
     *     summary="Get Stake History",
     *     tags={"Mobile"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="category id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="winning_tag_id",
     *         in="query",
     *         description="winning tag id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get Stake Items",  @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials",  @OA\JsonContent()),
     *     @OA\Response(response="404", description="Not Found",  @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getRaffles(Request $request, Utils $utils)
    {
        $request->validate([
            "category_id" => "required",
            "winning_tag_id" => "required"
        ]);
        $cat_id = Categories::where("cat_ref", $request->get("category_id"))->value("id");
        $win_tag_ref = WinningTags::where("win_tag_ref", $request->get("winning_tag_id"))->value("id");
        $stakes = StakePlatform::where("is_close", 0)
                    ->where("category_id", $cat_id)
                    ->where("winning_tags_id", $win_tag_ref)
                    ->with(["winningTags","categories"])->get();
        return $utils->message("success", $stakes, 200);
    }

    /**
     * @OA\Get (
     *     path="/api/v1/customer/raffles/all",
     *     summary="Get Stake History",
     *     tags={"Mobile"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Get Stake Items"),
     *     @OA\Response(response="401", description="Invalid credentials"),
     *     @OA\Response(response="404", description="Not Found"),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getStakeHistory(Request $request, Utils $utils)
    {
        $user_id = auth('sanctum')->user()->id;

        if(!User::where("id",$user_id)->exists())
            return $utils->message("success", "User Not Found", 200);

        $stakes = DB::table("customers_stakes")
            ->join("winning_tags", "customers_stakes.winning_tags_id", "=", "winning_tags.id")
            ->join("categories", "customers_stakes.category_id", "=", "categories.id")
            ->join("stake_platforms", "customers_stakes.stake_platform_id", "=", "stake_platforms.id")
            ->select(
                "customers_stakes.ticket_id",
                "customers_stakes.created_at",
                "customers_stakes.month as month",
                "customers_stakes.win",
                "customers_stakes.year",
                "stake_platforms.start_day",
                "winning_tags.name AS winning_tag_name",
                "winning_tags.stake_price",
                "categories.id AS category_id",
                "categories.name AS category_name",
            )
            ->where("user_id", $user_id)
            ->get();
        return $utils->message("success", $stakes, 200);

    }
    /**
     * @OA\Get (
     *     path="/api/v1/customer/raffles/active",
     *     summary="Get Stake History",
     *     tags={"Mobile"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Get Stake Items"),
     *     @OA\Response(response="401", description="Invalid credentials"),
     *     @OA\Response(response="404", description="Not Found"),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getActiveStakeHistory(Request $request, Utils $utils)
    {
        $user_id = auth('sanctum')->user()->id;

        if(!User::where("id", $user_id)->exists())
            return $utils->message("error", "User Not Found", 404);

        $stakes = DB::table("customers_stakes")
                    ->join("winning_tags", "customers_stakes.winning_tags_id", "=", "winning_tags.id")
                    ->join("categories", "customers_stakes.category_id", "=", "categories.id")
                    ->join("stake_platforms", "customers_stakes.stake_platform_id", "=", "stake_platforms.id")
                    ->where("stake_platforms.is_close", 0)
                    ->where("stake_platforms.is_open", 1)
                    ->select(
                        "customers_stakes.ticket_id",
                        "customers_stakes.created_at",
                        "customers_stakes.win as customer_win",
                        "customers_stakes.month as month",
                        "customers_stakes.year",
                        "winning_tags.stake_price",
                        "stake_platforms.start_day",
                        "winning_tags.name AS winning_tag_name",
                        "categories.name AS category_name",
                    )
                    ->where("user_id", $user_id)
                    ->get();
        return $utils->message("success", $stakes, 200);
    }


    /**
     * @OA\Get (
     *     path="/api/v1/customer/dashboard",
     *     summary="Get Dashboard Items",
     *     tags={"Mobile"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Get Dashboard Items",  @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials",  @OA\JsonContent()),
     *     @OA\Response(response="404", description="Not Found",  @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function dashboard(Request $request, Utils $utils)
    {

        $user_id =  auth('sanctum')->user()->id;;
        if(!User::where("id", $user_id)->exists())
            return $utils->message("error", "User Not Found", 404);

        $totalStake = Stake::where("user_id", $user_id)->count();
        $totalWin = Stake::where("user_id", $user_id)->where("win", 1)->count();
        $totalFundAdded = CustomerTransactionHistory::where("user_id", $user_id)->where("transaction_type", "Credit")->sum("amount");
        $totalFundWithdrawn = CustomerTransactionHistory::where("user_id", $user_id)->where("transaction_type", "Debit")->sum("amount");
        $activeStake = Stake::where("user_id", $user_id)->where("active", 1)->limit(3);
        $allStake = Stake::where("user_id", $user_id)->limit(3);

        $data = [
            "totalStake" => $totalStake,
            "totalWin" => $totalWin,
            "totalFundAdded" => $totalFundAdded,
            "totalFundWithdrawn" => $totalFundWithdrawn,
            "activeStake" => $activeStake,
            "allStake" =>  $allStake
        ];

        return $utils->message("success", $data, 200);

    }


    public function getAllDraws(Request $request, Utils $utils)
    {
        $data = [];
        $data = RaffleDrawsResource::collection(StakePlatform::with(["categories", "winningTags"])->orderBy("created_at", "DESC")->orderBy("created_at", "DESC")->get());
        return $utils->message("success", $data, 200);

    }
    /**
     * @OA\Post(
     *     path="/api/v1/staking/open",
     *     summary="Get Dashboard Items",
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="Category Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="winning_tags_id",
     *         in="query",
     *         description="Winning Tag Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Date format(YYYY-MM-DD)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get Dashboard Items"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function openStaking(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "category_id" => "required|string",
            "winning_tags_id" => "required|string",
            "win_nos" => "required|integer",
            "max_winner_count" => "required|integer",
            "stake_price" => "required|integer",
            "start_date" => "required"
        ]);
        $data =  explode("-",$request->get("start_date"));
        $stakePlatform = new StakePlatform();

        return  DB::transaction(function () use ($request, $stakePlatform, $data, $utils) {
            try {
                $stakePlatform->year = $data[0];
                $stakePlatform->month = $data[1];
                $stakePlatform->start_day = $data[2];
                $stakePlatform->stake_id = Str::random(10);
                $stakePlatform->is_open = 1;
                $stakePlatform->platform_ref = Str::random(50);
                $stakePlatform->category_id = Categories::where("cat_ref", $request->get("category_id"))->value('id'); ;
                $stakePlatform->winning_tags_id = WinningTags::where('win_tag_ref', $request->get("winning_tags_id"))->value("id"); ;
                $stakePlatform->win_nos = $request->get("win_nos");
                $stakePlatform->max_winner_count = $request->get("max_winner_count");
                $stakePlatform->stake_price = $request->get("stake_price");
                $stakePlatform->start_date = $request->get("start_date");
                $stakePlatform->end_date = $request->get("end_date");
                $stakePlatform->save();
                return $utils->message("success", $stakePlatform, 200);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                DB::rollBack();
                return $utils->message("error", $e->getMessage(), 400);
            }
        });
    }


    /**
     * @OA\Get(
     *     path="/api/v1/admin/customer-stake",
     *     summary="Get Dashboard Items",
     *     tags={"Admin"},
     *     @OA\Response(response="200", description="Get Dashboard Items"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function index(Request $request, Utils $utils)
    {
      $data =   DB::table("stake_platforms")
                ->join("customers_stakes", "stake_platforms.id", "=", "customers_stakes.stake_platform_id")
                ->join("winning_tags", "winning_tags.id", "=", "customers_stakes.winning_tags_id")
                ->join("categories", "categories.id", "=", "customers_stakes.category_id")
                ->select(
                  'categories.name AS category_name',
                  "stake_platforms.month",
                  "stake_platforms.is_open",
                  "stake_platforms.year",
                  "customers_stakes.win",
                  "winning_tags.name",
                  "customers_stakes.stake_platform_id",
                  "customers_stakes.stake_price",
                  'customers_stakes.ticket_id',
                  'customers_stakes.created_at',
                  'customers_stakes.stake_number',
                  'customers_stakes.payment_method',
                  'customers_stakes.stake_number',
              )
                ->where("role", "Customer")
              ->get();

        $Stake = StakeResource::collection($data);
        $winningTags = WinningTags::all();
        $total = Stake::where("role", "Customer")->sum("stake_price");
        $data = [
            'stakes' => $Stake,
            'winningTags' => WinningTagsResource::collection($winningTags),
            'total' =>  $total
        ];
        return $utils->message("success", $data, 200);
    }


    /**
     * @OA\Post(
     *     path="/api/v1/customer/stake/add",
     *     summary="Get Dashboard Items",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="Category Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="winning_tags_id",
     *         in="query",
     *         description="Winning Tag Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="month",
     *         in="query",
     *         description="Month",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="stake_price",
     *         in="query",
     *         description="stake_price",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="stake_number",
     *         in="query",
     *         description="stake_number",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="year",
     *         in="query",
     *         description="year",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="payment_method",
     *         in="query",
     *         description="Payment Method(card or wallet)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="stake_platform_id",
     *         in="query",
     *         description="",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="trx_ref",
     *         in="query",
     *         description="Transaction Ref from flutterwave",
     *         @OA\Schema(type="string")
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="Get Dashboard Items",  @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials",  @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function store(Request $request, Utils $utils)
    {
//        return Carbon::now();

        $stake_number = $request->get("stake_number");
        $stake_platform_id = $request->get("stake_platform_id");
        $request->validate([
            'category_id' => 'required|max:191',
            'stake_price' => 'required|max:10',
            'stake_number' => 'required|max:3',
            'month' => 'required|max:2',
            'year' => 'required|max:4',
            'winning_tags_id' => 'required',
            'payment_method' => 'required'
        ]);

        $user_id = auth('sanctum')->user()->id;
        if(!StakePlatform::where("platform_ref",$stake_platform_id)->where("is_open", 1)->where("is_close", 0)->exists())
            return $utils->message("error", "Raffle is closed", 422);


        if(StakePlatform::where("id",$stake_platform_id)->where("start_date", ">", \Carbon\Carbon::now())->exists())
            return $utils->message("error", "Raffle is not open yet", 422);

        if (!User::where("id", $user_id)->exists())
            return $utils->message("error", "User Does not Exist", 404);

         $win_number = StakePlatform::where("id", $request->get("stake_platform_id"))->value("win_nos");

         if(!NewCustomer::where("user_id", $user_id)->exists())
             return $utils->message("error", "User Not Found", 404);

        $ticket_id = Str::random(10);
        if (Stake::where("ticket_id", $ticket_id)->exists())
            return $utils->message("error", "Network Error. Please Try again", 500);


        $customer_balance = NewCustomer::where("user_id", $user_id)->value("wallet");
         $price = StakePlatform::where("platform_ref", $request->get("stake_platform_id"))->value("stake_price");

         if($request->get("payment_method") == "wallet"){
             if ($customer_balance >= $price){
                 $balance = $customer_balance - $price;

                   DB::transaction(function () use ($request, $balance, $utils, $user_id){
                     try {
                         $customer = NewCustomer::lockForUpdate()->where("user_id", $user_id)->firstOrFail();
                         $customer->wallet = $balance;
                         $customer->update();
                     } catch (\GuzzleHttp\Exception\ClientException $e) {
                         return $utils->message("error", $e->getMessage() , 400);
                     }
                 });

             }else{
                 return $utils->message("error", "Insufficient Balance", 422);
             }
         }

        $customer_id = NewCustomer::where("user_id", $user_id)->value("id") ;;

        Log::info("########## Stake and Customer Info #########", [
            "user_id" => $user_id,
            "customer_id" => $customer_id,
            "ticket_id" => $ticket_id,
            "stake_number" => $request->stake_number,
            "stake_platform_id" => $request->stake_platform_id,
            "payment_method" => $request->payment_method,
        ]);


        return  DB::transaction(function () use ($request, $customer_id, $utils, $ticket_id, $user_id, $price, $stake_platform_id){
            try {
                $stake = new Stake;
                $stake->user_id = $user_id;
                $stake->customer_id = $customer_id;
                $stake->ticket_id = $ticket_id;
                $stake->stake_price =$price;
                $stake->stake_number = $request->stake_number;
                $stake->win = 0;
                $stake->active = 1;
                $stake->role = "customer";
                $stake->month = $request->month;
                $stake->year = $request->year;
                $stake->winning_tags_id = WinningTags::where("win_tag_ref", $request->winning_tags_id)->value("id");
                $stake->category_id = Categories::where("cat_ref", $request->category_id)->value("id");
                $stake->payment_method = $request->get("payment_method");
                $stake->stake_platform_id = StakePlatform::where("platform_ref",  $request->get("stake_platform_id"))->value("id");
                $stake->save();


                $transactionHistory = new CustomerTransactionHistory;
                $transactionHistory->user_id = $user_id;
                $transactionHistory->customer_id = $customer_id;
                $transactionHistory->payment_method = $request->get("payment_method");
                $transactionHistory->amount = $price;
                $transactionHistory->transaction_type = "Debit";
                $transactionHistory->description = "Payment for ticket " . $ticket_id;
                $transactionHistory->transaction_ref = Str::random(10);
                $transactionHistory->save();
                DB::commit();
                return $utils->message("success", $stake, 200);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                DB::rollBack();
                return $utils->message("error", $e->getMessage() , 400);
            }
        });

    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Stake $stake)
    {
        //
        return new StakeResource($stake);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function customers_by_filter(Request $request)
    {
        //
        $winningTags = $request->input('win');
        $category = $request->input('category');
        $query = Stake::query();

        if ($winningTags) {
            $query->where('win', $winningTags);
        }

        if ($category) {
            $query->where('sub_cat_id', $category);
        }

        $customerStakes = $query->get();

        return response()->json($customerStakes);

    }
    /**
     * Total number of Customer stakes.
     */
    public function getTotalStakes()
    {
        $totalStakes = Stake::count();
        return response()->json(['total_stakes' => $totalStakes]);
    }
    public function getUserStakes($userId)
    {
        $userStakes = Stake::where('user_id', $userId)
            ->get();

        return response()
            ->json(['user_stakes' => $userStakes]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
