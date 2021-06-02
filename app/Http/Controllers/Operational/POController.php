<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Ticket;

class POController extends Controller
{
    public function poView(){
        $salespoint_ids = Auth::user()->location_access->pluck('salespoint_id');
        $tickets = Ticket::where('status',3)
        ->whereIn('salespoint_id',$salespoint_ids)
        ->get();
        return view('Operational.po', compact('tickets'));
    }

    public function podetailView($ticket_code){
        $ticket = Ticket::where('code',$ticket_code)->first();
        return view('Operational.podetail',compact('ticket'));
        return back()->with('error','Tiket tidak ditemukan');
    }
}
