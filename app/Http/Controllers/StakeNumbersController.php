<?php

namespace App\Http\Controllers;

use App\Models\Stake;
use App\Models\StakeNumbers;
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
     *     @OA\Response(response="200", description="List all the numbers"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function index(Utils $utils): JsonResponse
    {
        $stake_numbers = StakeNumbers::all();
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
     *     @OA\Response(response="200", description="Any number"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function store(Request $request, Utils $utils): JsonResponse
    {
        $request->validate([
            "stake_nos" => "required|int"
        ]);
        $stake_numbers = StakeNumbers::create($request->all());
        return $utils->message("success", $stake_numbers, 200);
    }
}
