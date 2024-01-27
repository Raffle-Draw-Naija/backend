<?php

namespace App\Http\Controllers;

use App\Http\Resources\StakeNumberResource;
use App\Models\Categories;
use App\Models\Stake;
use App\Models\StakeNumbers;
use App\Models\StakePlatform;
use App\Models\WinningTags;
use App\Utils\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;

class StakeNumbersController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/stake/numbers",
     *     summary="List all the numbers",
     *     tags={"General"},
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
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(response="200", description="winning tag id",  @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials",  @OA\JsonContent())
     * )
     */
    public function index(Request $request, Utils $utils)
    {
        $request->validate([
            "winning_tag_id" => 'required',
            "category_id" => 'required',
        ]);
        $category_id = Categories::where("cat_ref", $request->get("category_id"))->value("id") ;
        $winning_tag_id = WinningTags::where("win_tag_ref", $request->get("winning_tag_id"))->value("id");

        $max_winner_count = StakePlatform::where("category_id", $category_id)->where("winning_tags_id", $winning_tag_id)->value("max_winner_count");
        $win_no = StakePlatform::where("category_id", $category_id)->where("winning_tags_id", $winning_tag_id)->value("win_nos");
        $count_winners = StakePlatform::where("category_id", $category_id)->where("winning_tags_id", $winning_tag_id)->value("count_winners");

        if ($count_winners >= $max_winner_count)
            $stake_numbers = StakeNumbers::where("stake_nos", "!=", $win_no)->get();
        else
            $stake_numbers = StakeNumbers::all();

        return $utils->message("success", $stake_numbers, 200);
    }

    public function getAgentRaffleNumbers(Request $request, Utils $utils)
    {
        $request->validate([
            "stake_platform_ref" => 'required',
        ]);
        $category_id = StakePlatform::where("platform_ref", $request->get("stake_platform_ref"))->value("category_id");
        $winning_tags_id = StakePlatform::where("platform_ref", $request->get("stake_platform_ref"))->value("winning_tags_id");

        $category_id = Categories::where("id", $category_id)->value("id") ;
        $winning_tag_id = WinningTags::where("win_tag_ref", $winning_tags_id)->value("id");

        $max_winner_count = StakePlatform::where("platform_ref", $request->get("stake_platform_ref"))->value("max_winner_count");
        $win_no = StakePlatform::where("platform_ref", $request->get("stake_platform_ref"))->value("win_nos");
        $count_winners = StakePlatform::where("platform_ref", $request->get("stake_platform_ref"))->value("count_winners");

        if ($count_winners >= $max_winner_count)
            $stake_numbers = StakeNumberResource::collection(StakeNumbers::where("stake_nos", "!=", $win_no)->get());
        else
            $stake_numbers = StakeNumberResource::collection(StakeNumbers::all());

        return $utils->message("success", $stake_numbers, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/admin/stake/numbers/add",
     *     summary="Create numbers",
     *     tags={"Admin"},
     *     @OA\Parameter(
     *         name="stake_nos",
     *         in="query",
     *         description="Any number",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Any number",  @OA\JsonContent()),
     *     @OA\Response(response="401", description="Invalid credentials",  @OA\JsonContent())
     * )
     */
    public function store(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "stake_nos" => "required|int"
        ]);
        $stake_numbers = new StakeNumbers();
        $stake_numbers->stake_nos = $request->get("stake_nos");
        $stake_numbers->save();
        return $utils->message("success", $stake_numbers, 200);
    }
}
