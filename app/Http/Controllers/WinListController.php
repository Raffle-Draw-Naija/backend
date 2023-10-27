<?php

namespace App\Http\Controllers;

use App\Models\Stake;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WinListController extends Controller
{


    /**
     * @OA\Get(
     *     path="/api/v1/customer/get-win-history",
     *     summary="List all the Wins",
     *     tags={"Mobile"},
     *     @OA\Response(response="200", description="List all the Wins"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function index(Request $request, Utils $utils){
        $request->validate([
            'user_id' => 'required'
        ]);
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


    /**
     * @OA\Get(
     *     path="/api/v1/admin/customer/winners",
     *     summary="List all winners",
     *     tags={"Admin"},
     *     @OA\Response(response="200", description="List all winners"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getAllWinners(Request $request, Utils $utils): JsonResponse {
        $WinList = Stake::where('win', 1)->with(["customers", "categories", "subCategories", "winningTags"])->get();
        return $utils->message("success",$WinList, 200);
    }


    /**
     * @OA\Post(
     *     path="/api/v1/admin/customer/get-history",
     *     summary="List all winners by Date",
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         description="Start Date",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         description="End Date",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="List all winners by Date"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getAllWinnersByDate(Request $request, Utils $utils): JsonResponse {
        $start_date = $request->get("start_date");
        $end_date = $request->get("end_date");
        $WinList = Stake::where('win', 1)
                    ->with(["customers", "categories", "subCategories", "winningTags"])
                    ->whereBetween('created_at',[$start_date ." 00:00:00",$end_date ." 00:00:00"])
                    ->get();
        return $utils->message("success",$WinList, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/admin/customer/winners-by-category",
     *     summary="List all winners by Date",
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="Category ID",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="List all winners by Date"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function getAllWinnersByCategory(Request $request, Utils $utils): JsonResponse {
        $request->validate([
            "category_id" =>  "required"
        ]);
         $category_id = $request->get("category_id");
        $WinList = Stake::where('win', 1)
                    ->with(["customers", "categories", "subCategories", "winningTags"])
                    ->where('category_id', $category_id)
                    ->get();
        return $utils->message("success",$WinList, 200);
    }

}
