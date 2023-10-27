<?php

namespace App\Http\Controllers;

use App\Http\Resources\RaffleDrawsResource;
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
use Illuminate\Support\Str;


class CustomerStakeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/cutomer/dashboard",
     *     summary="Get Dashboard Items",
     *     tags={"Mobile"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="id of the user",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get Dashboard Items"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function dashboard(Request $request, Utils $utils)
    {
        $request->validate([
            "user_id" => "required"
        ]);
        $user_id = $request->get("user_id");
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
        $request->request->add(["is_open" => 1]);
        $data =  StakePlatform::create($request->except("start_date"));
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
    public function index(Request $request, Utils $utils): JsonResponse
    {
        $Stake = StakeResource::collection(Stake::with(["winningTags", "categories"])->orderBy("created_at", "DESC")->get());
        $winningTags = WinningTags::all();
        $total = 0;
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
     *         name="year",
     *         in="query",
     *         description="year",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="payment_method",
     *         in="query",
     *         description="Payment Method(card or credit)",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Get Dashboard Items"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function store(Request $request, Utils $utils)
    {
//        return Carbon::now();

        $request->validate([
            'user_id' => 'required|max:191',
            'category_id' => 'required|max:191',
            'stake_price' => 'required|max:191',
            'stake_number' => 'required|max:191',
            'win' => 'required|max:191',
            'month' => 'required|max:191',
            'year' => 'required|max:191',
            'winning_tags_id' => 'required|integer',
            'payment_method' => 'required'
        ]);
        if(!StakePlatform::where("category_id", $request->get("category_id"))->where("winning_tags_id",  $request->get("winning_tags_id"))->where("month", $request->get("month"))->where("year", $request->get("year"))->where("is_open", 1)->exists())
            return $utils->message("error", "Platform is not open yet", 401);

        if (User::where("id", $request->get("user_id"))->exists()) {
            $Stake = new Stake;
            $Stake->user_id = $request->user_id;
            $Stake->ticket_id = $request->ticket_id;
            $Stake->sub_cat_id = $request->sub_cat_id;
            $Stake->stake_price = $request->stake_price;
            $Stake->stake_number = $request->stake_number;
            $Stake->win = $request->win;
            $Stake->month = $request->month;
            $Stake->year = $request->year;
            $Stake->customer_id = $request->customer_id;
            $Stake->winning_tags_id = $request->winning_tags_id;
            $Stake->category_id = $request->category_id;
            $Stake->save();
            return $utils->message("success", $Stake, 200);

        } else {
            if ($win_number == $request->stake_number)
                $win = 1;
            else
                $win = 0;
            if (!NewCustomer::where("id", $request->get("user_id"))->exists())
                return $utils->message("error", "User Not Found", 404);
        $stake_platform_id = StakePlatform::where("category_id", $request->get("category_id"))->where("winning_tags_id",  $request->get("winning_tags_id"))->where("month", $request->get("month"))->where("year", $request->get("year"))->where("is_open", 1)->value("id");

         $win_number = StakePlatform::where("category_id", $request->get("category_id"))->where("winning_tags_id",  $request->get("winning_tags_id"))->where("month", $request->get("month"))->where("year", $request->get("year"))->value("win_nos");

         if($win_number == $request->stake_number){
             $win = 1;
             $stake_platform = StakePlatform::findOrFail($stake_platform_id);
             $stake_platform->count_winners += 1;
             $stake_platform->update();
         } else{
            $win = 0;
        }
         if(!NewCustomer::where("id",  $request->get("user_id"))->exists())
             return $utils->message("error", "User Not Found", 404);

         $customer_balance = NewCustomer::where("id", $request->get("user_id"))->value("wallet");
         $price = WinningTags::where("id", $request->get("winning_tags_id"))->value("stake_price");

         if($request->get("payment_method") == "Credit"){
             if($customer_balance >= $price)
                 $balance =  $customer_balance - $price;
             else
                 return $utils->message("error", "Insufficient Balance", 401);
         }

            $customer_balance = NewCustomer::where("id", $request->get("user_id"))->value("wallet");
            $price = WinningTags::where("id", $request->get("winning_tags_id"))->value("stake_price");
            if ($customer_balance >= $price)
                $balance = $customer_balance - $price;
            else
                return $utils->message("error", "Insufficient Balance", 401);

            $ticket_id = Str::random(10);
            if (Stake::where("ticket_id", $ticket_id)->exists())
                return $utils->message("error", "Network Error. Please Try again", 500);

            $Stake = new Stake;
            $Stake->user_id = $request->user_id;
            $Stake->ticket_id = $ticket_id;
            $Stake->sub_cat_id = $request->sub_cat_id;
            $Stake->stake_price = $request->stake_price;
            $Stake->stake_number = $request->stake_number;
            $Stake->win = $win;
            $Stake->month = $request->month;
            $Stake->year = $request->year;
            $Stake->customer_id = $request->customer_id;
            $Stake->winning_tags_id = $request->winning_tags_id;
            $Stake->category_id = $request->category_id;
            $Stake->save();

            $customer = NewCustomer::findorFail($request->get("user_id"));
            $customer->wallet = $balance;
            $customer->update();
        $Stake = new Stake;
        $Stake->user_id = $request->user_id;
        $Stake->ticket_id = $ticket_id;
        $Stake->sub_cat_id = $request->sub_cat_id;
        $Stake->stake_price = $request->stake_price;
        $Stake->stake_number = $request->stake_number;
        $Stake->win = $win;
        $Stake->active = 1;
        $Stake->month = $request->month;
        $Stake->year = $request->year;
        $Stake->customer_id = $request->customer_id;
        $Stake->winning_tags_id = $request->winning_tags_id;
        $Stake->category_id = $request->category_id;
        $Stake->payment_method = $request->get("payment_method");
        $Stake->stake_platform_id = $stake_platform_id;
        $Stake->save();

        if($request->get("payment_method") == "Credit"){
            $customer = NewCustomer::findorFail($request->get("user_id"));
            $customer->wallet = $balance;
            $customer->update();

            $transactionHistory = new CustomerTransactionHistory;
            $transactionHistory->user_id = $request->get("user_id");
            $transactionHistory->amount = $price;
            $transactionHistory->transaction_type = "Debit";
            $transactionHistory->description = "Payment for ticket " . $ticket_id;
            $transactionHistory->save();
        }
        return $utils->message("success", $Stake, 200);

            $transactionHistory = new CustomerTransactionHistory;
            $transactionHistory->user_id = $request->get("user_id");
            $transactionHistory->payment_method = "Credit";
            $transactionHistory->amount = $price;
            $transactionHistory->transaction_type = "Debit";
            $transactionHistory->description = "Payment for ticket " . $ticket_id;
            $transactionHistory->save();
            return $utils->message("success", $Stake, 200);
        }
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
