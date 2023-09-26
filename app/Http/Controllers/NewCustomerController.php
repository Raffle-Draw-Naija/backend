<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewCustomer;

class NewCustomerController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'first_name'=>'required|max:191',
            'last_name'=>'required|max:191',
            'identity'=>'required|max:191',
            'verified'=>'required|max:191',
            'phone'=>'required|max:191',
            'username'=>'required|max:191',
            'password'=>'required|max:191'
        ]);

        $newcustomer = new NewCustomer;
        $newcustomer->first_name = $request->first_name;
        $newcustomer->last_name = $request->last_name;
        $newcustomer->identity = $request->identity;
        $newcustomer->verified = $request->verified;
        $newcustomer->phone = $request->phone;
        $newcustomer->username = $request->username;
        $newcustomer->password = $request->password;
        $newcustomer->save();
        return response()->json(['message'=>'New Customer Added Successfully'], 200);

    }

}

/**class NewCustomerController2 extends Controller
{
    public function store(Request $request){

        $request->validate([
            'first_name'=>'required|max:191',
            'last_name'=>'required|max:191',
            'phone'=>'required|max:191',
        ]);

        $newcustomer = new NewCustomer;
        $newcustomer->first_name = $request->first_name;
        $newcustomer->last_name = $request->last_name;
        $newcustomer->phone = $request->phone;
        $newcustomer->save();
        return response()->json(['message'=>'New Customer Added Successfully'], 200);

    }

}
**/