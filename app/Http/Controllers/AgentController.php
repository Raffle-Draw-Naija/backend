<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\StakePlatform;
use App\Utils\ConstantValues\ConstantValues;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{

    public function checkBalance(Request $request, Utils $utils)
    {
        $request->validate([
            "amount" => "required|int"
        ]);
        $user_id = auth('sanctum')->user()->id;
        $balance = Agent::where("user_id", $user_id)->value("wallet");
        if ($balance < $request->get("amount"))
            return   $utils->message("error", "Insufficient Balance", 401);

        return  $utils->message("success", "Balance Validated Successful", 200);


    }
    public function validatePin(Request $request, Utils $utils)
    {
        $request->validate([
            "pin" => "required|int"
        ]);
         $pinFromDB = auth('sanctum')->user()->pin;
        if (!Hash::check($request->get("pin"), $pinFromDB))
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
            ->select("winning_tags.name as winningTags", "customers_stakes.stake_price as stakePrice", "customers_stakes.created_at as date", "customers_stakes.stake_number as  numberPicked")
            ->get();

        return $utils->message("success", $stakes, 200);
    }
}
