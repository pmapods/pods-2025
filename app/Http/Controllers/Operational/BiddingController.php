<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketItem;
use App\Models\TicketItemFileRequirement;
use App\Models\TicketItemAttachment;
use Auth;

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

    public function confirmFileRequirement(Request $request){
        try{
            if($request->type == 'file'){
                $item = TicketItemFileRequirement::findOrFail($request->id);
            }else if($request->type == 'attachment'){
                $item = TicketItemAttachment::findOrFail($request->id);
            }else{
                // ba_vendor
                $ticket = Ticket::findOrFail($request->id);
            }
            if($request->type == 'vendor'){
                $ticket->ba_status = 1;
                $ticket->ba_confirmed_by = Auth::user()->id;
                $ticket->save();
            }else{
                $item->status = 1;
                $item->confirmed_by = Auth::user()->id;
                $item->save();
            }
            return back()->with('success','Berhasil melakukan confirm kelengkapan');
        }catch(Exception $ex){
            return back()->with('error','Gagal melakukan confirm kelengkapan');
        }
    }

    public function rejectFileRequirement(Request $request){
        try{
            if($request->type == 'file'){
                // file
                $item = TicketItemFileRequirement::findOrFail($request->id);
            }else if($request->type == 'attachment'){
                // attachment
                $item = TicketItemAttachment::findOrFail($request->id);
            }else{
                // ba_vendor
                $ticket = Ticket::findOrFail($request->id);
            }
            
            if ($request->type == 'vendor') {
                $ticket->ba_status = -1;
                $ticket->ba_rejected_by = Auth::user()->id;
                $ticket->ba_reject_notes = $request->reason;
                $ticket->save();
            }else{
                $item->status = -1;
                $item->rejected_by = Auth::user()->id;
                $item->reject_notes = $request->reason;
                $item->save();
            }
            return back()->with('success','Berhasil melakukan reject kelengkapan');
        }catch(Exception $ex){
            return back()->with('error','Gagal melakukan reject kelengkapan');
        }
    }

    public function vendorSelectionView($ticket_code, $ticket_item_id){
        $ticket_item = TicketItem::find($ticket_item_id);
        $ticket = Ticket::where('code',$ticket_code)->first();
        // validate kalo misal item sama form codenya sesuai
        return view('Operational.vendorselection',compact('ticket_item','ticket'));
    }
}
