<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WinList;

class WinListController extends Controller
{
    //
    /**public function index(){

        $WinList = WinList::all();
        return response()->json([ 'WinList'=>$WinList], 200);

    }**/

    public function show($win){
        $WinList = WinList::where('win', '0')->get();

        if ($WinList) {

            return response()->json([ 'WinList'=>$WinList], 200);

        }
        else {

            return response()->json([ 'message '=>'No Record Found'], 404);
        }

        
        

    }
    
}
