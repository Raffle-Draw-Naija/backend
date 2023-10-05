<?php

namespace App\Http\Controllers;

use App\Models\Stake;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WinListController extends Controller
{
    //
    /**public function index(){

        $WinList = WinList::all();
        return response()->json([ 'WinList'=>$WinList], 200);

    }**/

    public function index(Request $request, Utils $utils){
        $user_id = $request->get("user_id");

        if (User::where("id", $user_id)->exists()){
            $WinList = Stake::where('win', 1)->where("user_id",$user_id)->get();
            if (count($WinList) > 0) {
                return $utils->message("success", $WinList, 200);
            }else{
                return $utils->message("success", "No Record Found", 200);
            }
        }else {
            return $utils->message("success", "User Not Found", 200);

        }
    }
    public function getAllWinners(Request $request, Utils $utils): JsonResponse {
        $WinList = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->get();
        return $utils->message("success",$WinList, 200);
    }
    public function getAllWinnersByDate(Request $request, Utils $utils): JsonResponse {
        $start_date = $request->get("start_date");
        $end_date = $request->get("end_date");
        $WinList = Stake::where('win', 1)
                    ->with(["customers", "categories", "subCategories", "winningTags"])
                    ->whereBetween('created_at',[$start_date ." 00:00:00",$end_date ." 00:00:00"])
                    ->get();
        return $utils->message("success",$WinList, 200);
    }

    public function getAllWinnersByCategory(Request $request, Utils $utils): JsonResponse {
         $category_id = $request->get("category_id");
        $WinList = Stake::where('win', 1)
                    ->with(["customers", "categories", "subCategories", "winningTags"])
                    ->where('category_id', $category_id)
                    ->get();
        return $utils->message("success",$WinList, 200);
    }

}
