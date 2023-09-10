<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stake;

class CustomerStakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $Stake = Stake::all();
         return response()->json(['Stake'=>$Stake]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=>'required|max:191',
            'ticket_id'=>'required|max:191',
            'sub_cat_id'=>'required|max:191',
            'stake_price'=>'required|max:191',
            'stake_number'=>'required|max:191',
            'win'=>'required|max:191',
            'month'=>'required|max:191',
            'year'=>'required|max:191'
        ]);




        $Stake = New  Stake;
        $Stake->user_id = $request->user_id;
        $Stake->ticket_id = $request->ticket_id;
        $Stake->sub_cat_id = $request->sub_cat_id;
        $Stake->stake_price = $request->stake_price;
        $Stake->stake_number = $request->stake_number;
        $Stake->win = $request->win;
        $Stake->month = $request->month;
        $Stake->year = $request->year;
        $Stake->save();
        return response()->json(['massage'=> 'Customer stake add successfully'], 200);
        

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
