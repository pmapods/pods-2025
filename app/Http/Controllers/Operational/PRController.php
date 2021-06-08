<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Ticket;
use App\Models\Authorization;
class PRController extends Controller
{
    public function prView(){
        $salespoint_ids = Auth::user()->location_access->pluck('salespoint_id');
        $tickets = Ticket::where('status',3)
        ->whereIn('salespoint_id',$salespoint_ids)
        ->get();
        return view('Operational.pr', compact('tickets'));
    }

    public function prDetailView($ticket_code){
        try{
            $ticket = Ticket::where('code',$ticket_code)->first();
            if(!$ticket){
                return back()->with('error',"Ticket tidak ditemukan");
            }
            $authorizations = Authorization::where('form_type',2)->get();
            return view('Operational.prdetail',compact('ticket','authorizations'));
        }catch(\Exception $ex){
            return back()->with('error','gagal membuka detil PR '.$ex->getMessage());
        }
    }

    public function addNewPR(Request $request){
        $messages = [
            'pr_authorization_id.required'  => 'Otorisasi PR wajib dipilih',
            'updated_at.required' =>'Updated at data not received, Please contact admin'
        ];
        $validated = $request->validate([
            'ticket_id' => 'required',
            'pr_authorization_id' => 'required',
        ],$messages);
        
        dd($request);
    }
}
