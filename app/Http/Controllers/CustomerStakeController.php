<?php

namespace App\Http\Controllers;

use App\Http\Resources\StakeResource;
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
use Illuminate\Support\Str;


class CustomerStakeController extends Controller
{
    public function openStaking(Request $request, Utils $utils)
    {
        $request->validate([
            "category_id" => "required|integer",
            "winning_tags_id" => "required|integer",
            "month" => "required|integer",
            "year" => "required|integer"
        ]);

        $data =  StakePlatform::create($request->all());
        return $utils->message("success", $data, 200);

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Utils $utils): JsonResponse
    {
        $Stake = Stake::all();
        return $utils->message("success", $Stake, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Utils $utils)
    {
        $request->validate([
            'user_id' => 'required|max:191',
            'sub_cat_id' => 'required|max:191',
            'stake_price' => 'required|max:191',
            'stake_number' => 'required|max:191',
            'win' => 'required|max:191',
            'month' => 'required|max:191',
            'year' => 'required|max:191',
            'customer_id' => 'required|integer',
            'winning_tags_id' => 'required|integer',
            'category_id' => 'required|integer'
        ]);
        if(!StakePlatform::where("category_id", $request->get("category_id"))->where("winning_tags_id",  $request->get("winning_tags_id"))->where("month", $request->get("month"))->where("year", $request->get("year"))->where("is_open", 1)->exists())
            return $utils->message("error", "Platform is not open yet", 404);
         $win_number = WinNumbers::where("category_id", $request->get("category_id"))->where("winning_tag_id",  $request->get("winning_tags_id"))->where("month", $request->get("month"))->where("year", $request->get("year"))->value("win_num");

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
