<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stake_numbers;

class StakeNumbersController extends Controller
{
    public function index(){

        $stake_numbers = stake_numbers::all();
        return response()->json([ 'stake_numbers'=>$stake_numbers], 200);

    }
}
