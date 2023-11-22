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
use Illuminate\Support\Str;


class CustomerStakeController extends Controller
{

    /**
     * @OA\Get   (
     *     path="/api/v1/customer/get-raffles",
     *     summary="Get Stake History",
     *     tags={"Mobile"},
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
        $stakes = StakePlatform::where("is_close", 0)->where("category_id", $request->get("category_id"))->where("winning_tags_id", $request->get("winning_tag_id"))->with(["winningTags","categories"])->get();
        return $utils->message("success", $stakes, 200);
    }

    /**
     * @OA\Get (
     *     path="/api/v1/customer/raffles/all",
     *     summary="Get Stake History",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="id of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get Stake Items"),
     *     @OA\Response(response="401", description="Invalid credentials"),
     *     @OA\Response(response="404", description="Not Found"),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getStakeHistory(Request $request, Utils $utils)
    {
        $request->validate([
            "user_id" => "required"
        ]);

        if(!Stake::where("user_id", $request->get("user_id"))->exists())
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
                "categories.name AS category_name",
            )
            ->get();
        return $utils->message("success", $stakes, 200);

    }
    /**
     * @OA\Get (
     *     path="/api/v1/customer/raffles/active",
     *     summary="Get Stake History",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="id of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get Stake Items"),
     *     @OA\Response(response="401", description="Invalid credentials"),
     *     @OA\Response(response="404", description="Not Found"),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function getActiveStakeHistory(Request $request, Utils $utils)
    {
        $request->validate([
            "user_id" => "required"
        ]);

        if(!Stake::where("user_id", $request->get("user_id"))->exists())
            return $utils->message("success", "User Not Found", 404);

        $stakes = DB::table("customers_stakes")
                    ->join("winning_tags", "customers_stakes.winning_tags_id", "=", "winning_tags.id")
                    ->join("categories", "customers_stakes.category_id", "=", "categories.id")
                    ->join("stake_platforms", "customers_stakes.stake_platform_id", "=", "stake_platforms.id")
                    ->where("stake_platforms.is_close", 0)
                    ->where("stake_platforms.is_open", 1)
                    ->select(
                        "customers_stakes.ticket_id",
                        "customers_stakes.created_at",
                        "customers_stakes.month as month",
                        "customers_stakes.year",
                        "customers_stakes.win",
                        "winning_tags.stake_price",
                        "stake_platforms.start_day",
                        "winning_tags.name AS winning_tag_name",
                        "categories.name AS category_name",
                    )
                    ->get();
        return $utils->message("success", $stakes, 200);
    }


    /**
     * @OA\Get (
     *     path="/api/v1/customer/dashboard",
     *     summary="Get Dashboard Items",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="id of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get Dashboard Items",  @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials",  @OA\JsonContent()),
     *     @OA\Response(response="404", description="Not Found",  @OA\JsonContent()),
     *     @OA\Response(response="422", description="validation Error", @OA\JsonContent())
     *
     * )
     */
    public function dashboard(Request $request, Utils $utils)
    {
        $request->validate([
            "user_id" => "required"
        ]);

        $user_id = $request->get("user_id");
        if(!User::where("id", $user_id)->exists())
            return $utils->message("error", "User Not Found", 404);

        $totalStake = Stake::where("user_id", $user_id)->count();
        $totalWin = Stake::where("user_id", $user_id)->where("win", 1)->count();
        $totalFundAdded = CustomerTransactionHistory::where("user_id", $user_id)->where("transaction_type", "Credit")->count();
        $totalFundWithdrawn = CustomerTransactionHistory::where("user_id", $user_id)->where("transaction_type", "Debit")->count();
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
        $data = RaffleDrawsResource::collection(StakePlatform::with(["categories", "winningTags"])->orderBy("created_at", "DESC")->get());
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
            "category_id" => "required|integer",
            "winning_tags_id" => "required|integer",
            "start_date" => "required"
        ]);
        $data =  explode("-",$request->get("start_date"));
        $request->request->add(["year" => $data[0]]);
        $request->request->add(["month" => $data[1]]);
        $request->request->add(["start_day" => $data[2]]);
        $request->request->add(["stake_id" => Str::random(10)]);
        $request->request->add(["is_open" => 1]);
        $data =  StakePlatform::create($request->all());
        return $utils->message("success", $data, 200);

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
              ->where("stake_platforms.is_open", 0)
              ->where("stake_platforms.is_close", 1)
              ->get();

        $Stake = StakeResource::collection($data);
        $winningTags = WinningTags::all();
        $total = Stake::sum("stake_price");
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
     *         name="user_id",
     *         in="query",
     *         description="User Id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
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
     *     @OA\Parameter(
     *         name="customer_id",
     *         in="query",
     *         description="Id of the customer",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get Dashboard Items"),
     *     @OA\Response(response="401", description="Invalid credentials"),
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
            'user_id' => 'required|max:191',
            'category_id' => 'required|max:191',
            'stake_price' => 'required|max:191',
            'stake_number' => 'required|max:191',
            'month' => 'required|max:191',
            'year' => 'required|max:191',
            'winning_tags_id' => 'required|integer',
            'payment_method' => 'required'
        ]);
        if(!StakePlatform::where("id",$stake_platform_id)->where("is_open", 1)->where("is_close", 0)->exists())
            return $utils->message("error", "Platform is not open yet", 422);

        if (!User::where("id", $request->get("user_id"))->exists())
            return $utils->message("error", "User Does not Exist", 404);

         $win_number = StakePlatform::where("id", $request->get("stake_platform_id"))->value("win_nos");

         if($win_number == $request->stake_number){
             $win = 1;
             $stake_platform = StakePlatform::findOrFail($request->get("stake_platform_id"));
             $stake_platform->count_winners += 1;
             $stake_platform->update();
         } else{
            $win = 0;
        }
         if(!NewCustomer::where("user_id",  $request->get("user_id"))->exists())
             return $utils->message("error", "User Not Found", 404);

         $customer_balance = NewCustomer::where("user_id", $request->get("user_id"))->value("wallet");
         $price = WinningTags::where("id", $request->get("winning_tags_id"))->value("stake_price");

         if($request->get("payment_method") == "wallet"){
             if ($customer_balance >= $price){
                 $balance = $customer_balance - $price;
                 $customer = NewCustomer::where("user_id", $request->get("user_id"))->firstOrFail();
                 $customer->wallet = $balance;
                 $customer->update();
             }else{
                 return $utils->message("error", "Insufficient Balance", 401);
             }
         }

        $customer_balance = NewCustomer::where("id", $request->get("user_id"))->value("wallet");
        $price = WinningTags::where("id", $request->get("winning_tags_id"))->value("stake_price");
        $ticket_id = Str::random(10);
        if (Stake::where("ticket_id", $ticket_id)->exists())
            return $utils->message("error", "Network Error. Please Try again", 500);


        $Stake = new Stake;
        $Stake->user_id = $request->user_id;
        $Stake->customer_id = $request->customer_id;
        $Stake->ticket_id = $ticket_id;
        $Stake->stake_price = $request->stake_price;
        $Stake->stake_number = $request->stake_number;
        $Stake->win = $win;
        $Stake->active = 1;
        $Stake->month = $request->month;
        $Stake->year = $request->year;
        $Stake->winning_tags_id = $request->winning_tags_id;
        $Stake->category_id = $request->category_id;
        $Stake->payment_method = $request->get("payment_method");
        $Stake->stake_platform_id = $stake_platform_id;
        $Stake->save();


        $transactionHistory = new CustomerTransactionHistory;
        $transactionHistory->user_id = $request->get("user_id");
        $transactionHistory->customer_id = $request->get("customer_id");
        $transactionHistory->payment_method = $request->get("payment_method");
        $transactionHistory->amount = $price;
        $transactionHistory->transaction_type = "Debit";
        $transactionHistory->description = "Payment for ticket " . $ticket_id;
        $transactionHistory->transaction_ref = Str::random(10);
        $transactionHistory->save();
        return $utils->message("success", $Stake, 200);

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
