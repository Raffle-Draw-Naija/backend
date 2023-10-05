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
    public function index(Utils $utils): JsonResponse
    {
        $stake_numbers = StakeNumbers::all();
        return $utils->message("success", $stake_numbers, 200);

    }

    public function store(Request $request, Utils $utils): JsonResponse
    {

        $request->validate([
            "stake_nos" => "required|int"
        ]);
        $stake_numbers = StakeNumbers::create($request->all());
        return $utils->message("success", $stake_numbers, 200);

    }
}
