<?php

namespace App\Http\Controllers;

use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\WinNumbers;
class WinNumbersController extends Controller
{

    public function store(Request $request, Utils $utils)
    {
        $request->validate([
            "category_id" => "required|integer",
            "winning_tag_id" => "required|integer",
            "month" => "required|integer",
            "year" => "required|integer",
            "win_num" => "required|integer"
        ]);

        return  DB::transaction(function () use ($request, $utils) {
            try {
                $identity = Str::random(20);
                if (WinNumbers::where("identity", $identity)->exists())
                    return $utils->message("error", "Network Error. Please Try again", 500);
                $winNumbers = new WinNumbers();
                $winNumbers->category_id = $request->get("category_id");
                $winNumbers->winning_tag_id = $request->get("winning_tag_id");
                $winNumbers->month = $request->get("month");
                $winNumbers->year = $request->get("year");
                $winNumbers->year = $request->get("year");
                $winNumbers->win_num = $request->get("win_num");
                $winNumbers->identity = $request->get("identity");
                $winNumbers->save();

;                return $utils->message("success", "Win Number Created Successfully...", 201);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                return $utils->message("error", $e->getMessage(), 400);
            }
        });
    }
}
