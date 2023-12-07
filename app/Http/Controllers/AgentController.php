<?php

namespace App\Http\Controllers;

use App\Models\StakePlatform;
use App\Utils\Utils;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function getRaffles(Utils $utils)
    {
        $stakes =  DB::table('customer_stakes')
            ->join('customer_stakes', 'winning_tags.id', '=', 'customer_stakes.winning_tags_id')
            ->join('followers', 'followers.user_id', '=', 'users.id')
            ->where('followers.follower_id', '=', 3)
            ->get();

        StakePlatform::where("is_close", 1)->with(["winningTags","categories"])->get();
        return $utils->message("success", $stakes, 200);
    }
}
