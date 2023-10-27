<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Http\Resources\StakeResource;
use App\Models\NewCustomer;
use App\Models\Stake;
use App\Models\WinningTags;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function searchByDate(Request $request, Utils $utils)
    {
        $searchValues = $request->get("search_value");
        $from =  $request->get("start_date");
        $to =  $request->get("end_date");
        $search_item =  $request->get("search_item");
        $winningTag =  $request->get("winningTag");

        $WinList=[];
        if(empty($search_item) && empty($winningTag)){
            if (!empty($from) && !empty($to))
              if ($searchValues == "winners")
                $WinList = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->whereBetween('created_at', [$from, $to])->get();
              else
                $WinList = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->whereBetween('created_at', [$from, $to])->get();

            else
                $WinList = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->get();

        }else if(!empty($search_item) && empty($winningTag)){
            if (!empty($from) && !empty($to))
                if ($searchValues == "winners")
                    $WinList = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->whereBetween('created_at', [$from, $to])->get();
                else
                    $WinList = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->whereBetween('created_at', [$from, $to])->get();

            else
                $WinList = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->get();

        }else if(empty($search_item) && !empty($winningTag)){
            if (!empty($from) && !empty($to))
                if ($searchValues == "winners")
                    $WinList = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("winning_tags-id", $winningTag)->whereBetween('created_at', [$from, $to])->get();
                else
                    $WinList = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->where("winning_tags-id", $winningTag)->whereBetween('created_at', [$from, $to])->get();
            else
                $WinList = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("winning_tags-id", $winningTag)->get();

        }else if(!empty($search_item) && !empty($winningTag)){
            if (!empty($from) && !empty($to))
                if ($searchValues == "winners")
                    $WinList = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->where("winning_tags-id", $winningTag)->whereBetween('created_at', [$from, $to])->get();
                else
                    $WinList = Stake::where('win', 0)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->where("winning_tags-id", $winningTag)->whereBetween('created_at', [$from, $to])->get();
            else
                $WinList = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->where("ticket_id", $search_item)->where("winning_tags-id", $winningTag)->get();

        }

        return $utils->message("success",StakeResource::collection($WinList), 200);
    }
    public function customers(Request $request, Utils $utils): JsonResponse
    {
        $customers = CustomerResource::collection(NewCustomer::all());
        return $utils->message("success", $customers, 200);
    }
    public function dashboard(Request $request, Utils $utils): JsonResponse
    {
        $stake = Stake::count();
        $recentStake = StakeResource::collection(Stake::limit(3)->get());
        $data = [
            'stakesCount' => $stake,
            'recentStakes' => $recentStake
        ];
        return $utils->message("success", $data, 200);
    }

    public function updateWinningTag($id, Request $request, Utils $utils)
    {
        $winningTag = WinningTags::findOrFail($id);
        $winningTag->name = $request->get("name");
        $winningTag->stake_price = $request->get("stake_price");
        $winningTag->update();
        return $utils->message("success", $winningTag, 200);

    }
}
