<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\NotifyParty;
use DB;
class SyncronizationController extends Controller
{
    public function synTradingItem(Request $request){
 
        $request->party_code;
        $party=NotifyParty::where('code', $request->party_code)->first();
        $party_id=$party->id;
        $results=DB::select("CALL PROC_GLOBAL_TRADING(?)",[$party_id]);
         
    }
}
