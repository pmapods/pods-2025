<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidding;

use Crypt;

class APIController extends Controller
{
    public function updateAssetNumber(Request $request){
        return response()->json([
            'success' => 'successfully access update asset number function'
        ],200);
    }

    public function printBidding($encrypted_bidding_id){
        try {
            $decrypted = Crypt::decryptString($encrypted_bidding_id);
        } catch (\Exception $ex) {
            abort(404);
        }
        $bidding = Bidding::find($decrypted);
        $ticket_item = $bidding->ticket_item;
        $ticket = $bidding->ticket;
        return view('Operational.biddingprintoutview',compact('ticket_item','ticket','bidding'));
    }
}
