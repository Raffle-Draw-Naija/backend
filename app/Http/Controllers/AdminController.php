<?php

namespace App\Http\Controllers;

use App\Http\Resources\Agent;
use App\Http\Resources\AgentCollection;
use App\Http\Resources\AgentResource;
use App\Http\Resources\CustomerGraphResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\RaffleDrawsResource;
use App\Http\Resources\StakeResource;
use App\Models\AgentStakes;
use App\Models\AgentTransactionHistory;
use App\Models\NewCustomer;
use App\Models\Stake;
use App\Models\StakePlatform;
use App\Models\User;
use App\Models\WinningTags;
use App\Tests;
use App\Utils\Utils;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function adminGetTags($identity, Utils $utils)
    {
        $id = User::where("identity", $identity)->value("id");
        $historyData =  DB::table("stake_platforms")
            ->join("agent_stakes", "stake_platforms.id", "=", "agent_stakes.stake_platform_id")
            ->join("winning_tags", "winning_tags.id", "=", "agent_stakes.winning_tags_id")
            ->join("categories", "categories.id", "=", "agent_stakes.category_id")
            ->select(
                'categories.name AS category_name',
                "stake_platforms.month",
                "stake_platforms.year",
                "agent_stakes.win",
                "winning_tags.name",
                "agent_stakes.stake_platform_id",
                "agent_stakes.stake_price AS stakePrice",
                'agent_stakes.ticket_id',
                'agent_stakes.created_at',
                'agent_stakes.stake_number',
                'agent_stakes.stake_number',
            )
            ->where("agent_stakes.user_id", $id)
            ->orderBy("created_at", "DESC")
            ->get();


        $data = [
          "total" => AgentStakes::where("user_id",$id)->sum("stake_price"),
          "history" => $historyData
        ];
        return $utils->message("success", $data, 200);
    }
    public function getAgents(Request $request, Utils $utils)
    {
        $agents = \App\Models\User::where("role", "Agent")->with(["agents"])->get();
        return $utils->message("success",  AgentResource::collection($agents), 200);

    }
    public function searchByDate(Request $request, Utils $utils)
    {
        $searchValues = $request->get("search_value");
        $from =  $request->get("start_date");
        $to =  $request->get("end_date");
        $search_item =  $request->get("search_item");
        $winningTag =  $request->get("winningTag");

        $res=[];
        $sum=0;

        if(empty($search_item) && empty($winningTag)){
            if (!empty($from) && !empty($to)) {
                if(!empty($winningTag)){
                    if ($searchValues == "winners") {
                        $res = Stake::where('win', 1)->where("winning_tags_id", $winningTag)->with(["customers", "categories", "subCategories", "winningTags"])->whereBetween('created_at', [$from, $to])->get();
                        $sum = Stake::where('win', 1)->where("winning_tags_id", $winningTag)->with(["customers", "categories", "subCategories", "winningTags"])->whereBetween('created_at', [$from, $to])->sum("stake_price");
                    }else{
                        $res = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->whereBetween('created_at', [$from, $to])->get();
                        $sum = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->whereBetween('created_at', [$from, $to])->sum("stake_price");
                    }
                } else {
                    if ($searchValues == "winners") {
                        $res = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->whereBetween('created_at', [$from, $to])->get();
                        $sum = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->whereBetween('created_at', [$from, $to])->sum("stake_price");
                    }else{
                        $res = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->whereBetween('created_at', [$from, $to])->get();
                        $sum = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->whereBetween('created_at', [$from, $to])->sum("stake_price");
                    }
                }
            }else{
                if ($searchValues == "winners") {
                    $res = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->get();
                    $sum = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->sum("stake_price");
                } else {
                    $res = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->get();
                    $sum = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->sum("stake_price");
                }
            }

        }else if(!empty($search_item) && empty($winningTag)){
            if (!empty($from) && !empty($to)){
                if ($searchValues == "winners"){
                    $res = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->whereBetween('created_at', [$from, $to])->get();
                    $sum = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->whereBetween('created_at', [$from, $to])->sum("stake_price");
                }
                else{
                    $res = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->whereBetween('created_at', [$from, $to])->get();
                    $sum = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->whereBetween('created_at', [$from, $to])->sum("stake_price");
                }
            }
            else{
                $res = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->get();
                $sum = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->sum("stake_price");
            }

        }else if(empty($search_item) && !empty($winningTag)){
            if (!empty($from) && !empty($to)) {
                if ($searchValues == "winners") {
                    $res = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("winning_tags_id", $winningTag)->whereBetween('created_at', [$from, $to])->get();
                    $sum = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("winning_tags_id", $winningTag)->whereBetween('created_at', [$from, $to])->sum("stake_price");
                } else {
                    $res = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->where("winning_tags_id", $winningTag)->whereBetween('created_at', [$from, $to])->get();
                    $sum = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->where("winning_tags_id", $winningTag)->whereBetween('created_at', [$from, $to])->sum("stake-price");
                }
            }else{
                $res = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("winning_tags_id", $winningTag)->get();
                $sum = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("winning_tags_id", $winningTag)->sum("stake_price");
            }

        }else if(!empty($search_item) && !empty($winningTag)){
            if (!empty($from) && !empty($to)){
                if ($searchValues == "winners"){
                    $res = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->where("winning_tags-id", $winningTag)->whereBetween('created_at', [$from, $to])->get();
                    $res = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->where("winning_tags-id", $winningTag)->whereBetween('created_at', [$from, $to])->sum("stake_price");
                }else{
                    $res = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->where("winning_tags-id", $winningTag)->whereBetween('created_at', [$from, $to])->get();
                    $res = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->where("winning_tags-id", $winningTag)->whereBetween('created_at', [$from, $to])->sum("stake_price");
                }
            } else{
                $res = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->where("winning_tags-id", $winningTag)->get();
                $sum = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->where("winning_tags-id", $winningTag)->sum("stake_price");
            }

        }

        $data = [
            "res" => StakeResource::collection($res),
            "total" => $sum
        ];

        return $utils->message("success", $data, 200);
    }
    public function customers(Request $request, Utils $utils): JsonResponse
    {
        $customers = CustomerResource::collection(NewCustomer::all());
        return $utils->message("success", $customers, 200);
    }
    public function dashboard(Request $request, Utils $utils)
    {
        $recentStake = StakeResource::collection(Stake::limit(3)->orderBy("created_at", "DESC")->get());
        $recentCustomer = CustomerGraphResource::collection(NewCustomer::limit(5)->get());

//        $customers = NewCustomer::select(
//            DB::raw("(count(id)) as count"),
//            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months"),
//            DB::raw("DATE_FORMAT(created_at,'%m') as monthKey")
//        )->orderBy('created_at')
//            ->groupBy(["months", "monthKey"])
//            ->get();

//        $newCustomers = [];
//        foreach($customers as $customer){
//            array_push($newCustomers, ['count' => $customer->count, "year" => Carbon::parse($customer->months)->format("M, Y")]);
//        }

//        $stakesData = Stake::select(
//            DB::raw("(sum(stake_price)) as amount"),
//            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months"),
//            DB::raw("DATE_FORMAT(created_at,'%m') as monthKey")
//        )->orderBy('created_at')
//            ->groupBy(["months", "monthKey"])
//            ->get();
//
//        $newStakes = [];
//        foreach($stakesData as $stake){
//            array_push($newStakes, ['amount' => $stake->amount, "year" => Carbon::parse($stake->months)->format("M, Y")]);
//        }
        $stake = Stake::count();
        $agentStake = AgentStakes::count();
        $agentTrans = AgentTransactionHistory::count();

        $data = [
            'stakesCount' => $stake,
            'agentStake' => $agentStake,
            'agentTrans' => $agentTrans,
//            'stakesGraphData' => $newStakes,
//              'customerGraphData' => $newCustomers,
        ];
        return $utils->message("success", $data, 200);
    }

    public function updateWinningTag($id, Request $request, Utils $utils)
    {

        return  DB::transaction(function () use ($request, $id, $utils) {
            try {
                $id = WinningTags::lockForUpdate()->where("win_tag_ref", $id)->value("id");
                $winningTag = WinningTags::findOrFail($id);
                $winningTag->name = $request->get("name");
                $winningTag->stake_price = $request->get("stake_price");
                $winningTag->update();
                return $utils->message("success", $winningTag, 200);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                DB::rollBack();
                return $utils->message("error", $e->getMessage(), 400);
            }
        });

    }
}
