<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketItem;

class BiddingController extends Controller
{
    public function biddingView(){
        $biddings = Ticket::where('status',2)->get();
        return view('Operational.bidding',compact('biddings'));
    }

    public function biddingDetailView($ticket_code){
        $ticket = Ticket::where('code',$ticket_code)->first();
        if($ticket->status < 2){
            return back()->with('error','Tiket belum siap untuk dilakukan proses bidding');
        }
        return view('Operational.biddingdetail',compact('ticket'));
    }

    public function vendorSelectionView($ticket_code, $ticket_item_id){
        $ticket_item = TicketItem::find($ticket_item_id);
        $ticket = Ticket::where('code',$ticket_code)->first();
        // validate kalo misal item sama form codenya sesuai
        return view('Operational.vendorselection',compact('ticket_item','ticket'));
    }
}
