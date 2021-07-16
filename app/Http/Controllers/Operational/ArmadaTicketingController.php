<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

use App\Models\ArmadaTicket;

class ArmadaTicketingController extends Controller
{
    public function createArmadaticket(Request $request){
        try {
            $count_ticket = ArmadaTicket::whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->withTrashed()
            ->count();
            do {
                $code = "ARM-".now()->translatedFormat('ymd').'-'.str_repeat("0", 4-strlen($count_ticket+1)).($count_ticket+1);
                $count_ticket++;
                $checkticket = ArmadaTicket::where('code',$code)->first();
                ($checkticket)? $flag = false : $flag = true;
            } while (!$flag);

            $newTicket                   = new ArmadaTicket;
            $newTicket->code             = $code;
            $newTicket->requirement_date = $request->requirement_date;
            $newTicket->salespoint_id    = $request->salespoint_id;
            $newTicket->isNiaga          = $request->isNiaga;
            $newTicket->ticketing_type   = $request->pengadaan_type;
            $newTicket->armada_type_id   = $request->armada_type;
            $newTicket->created_by       = Auth::user()->id;
            $newTicket->save();

            return redirect('/ticketing')->with('success','Berhasil membuat ticketing armada');
        } catch (\Exception $ex) {
            return back()->with('error','Gagal membuat ticketing armada ('.$ex->getMessage().')');
        }
    }

    public function armadaTicketDetail(Request $request, $code){
        $armadaticket = ArmadaTicket::where('code',$code)->first();
        try { 
            if(!$armadaticket){
                throw new \Exception('Ticket armada dengan kode '.$code.'tidak ditemukan');
            }
            return view('Operational.Armada.armadaticketdetail',compact('armadaticket'));
        } catch (\Exception $ex) {
            return redirect('/ticketing')->with('error','Gagal membukan detail ticket armada '.$ex->getMessage());
        }
    }
}
