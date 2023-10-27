<?php

namespace App\Http\Controllers;

use App\Utils\Utils;
use Illuminate\Http\Request;
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
        $identity = Str::random(20);
        if (WinNumbers::where("identity", $identity)->exists())
            return $utils->message("error", "Network Error. Please Try again", 500);
        $request->request->add(["identity" => $identity]);
        $data = WinNumbers::create($request->all());
        return $utils->message("success", $data, 201);

    }
}
