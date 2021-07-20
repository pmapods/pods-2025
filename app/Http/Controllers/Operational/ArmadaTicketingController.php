<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;

use App\Models\Ticket;
use App\Models\Armada;
use App\Models\ArmadaTicket;
use App\Models\Authorization;
use App\Models\EmployeePosition;
use App\Models\EmployeeLocationAccess;
use App\Models\SalesPoint;

class ArmadaTicketingController extends Controller
{
    public function createArmadaticket(Request $request){
        try {
            $armada_ticket_count = ArmadaTicket::whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->withTrashed()
            ->count();

            $barang_ticket_count = Ticket::whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->where('status','>',0)
            ->withTrashed()
            ->count();

            $total_count = $armada_ticket_count + $barang_ticket_count;
            do {
                $code = "PCD-".now()->translatedFormat('ymd').'-'.str_repeat("0", 4-strlen($total_count+1)).($total_count+1);
                $total_count++;
                $checkticket = ArmadaTicket::where('code',$code)->first();
                ($checkticket)? $flag = false : $flag = true;
            } while (!$flag);

            $newTicket                   = new ArmadaTicket;
            $newTicket->code             = $code;
            $newTicket->requirement_date = $request->requirement_date;
            $newTicket->salespoint_id    = $request->salespoint_id;
            $newTicket->isNiaga          = $request->isNiaga;
            $newTicket->ticketing_type   = $request->pengadaan_type;
            if($newTicket->ticketing_type == 0){
                $newTicket->armada_type_id   = $request->armada_type_id;
            }
            if(in_array($newTicket->ticketing_type,[1,2,3])){
                $newTicket->armada_type_id   = Armada::find($request->armada_id)->armada_type->id;
                $newTicket->armada_id        = $request->armada_id;
            }
            $newTicket->created_by       = Auth::user()->id;
            $newTicket->save();

            return redirect('/ticketing')->with('success','Berhasil membuat ticketing armada');
        } catch (\Exception $ex) {
            dd($ex);
            return back()->with('error','Gagal membuat ticketing armada ('.$ex->getMessage().')');
        }
    }

    public function armadaTicketDetail(Request $request, $code){
        $armadaticket = ArmadaTicket::where('code',$code)->first();

        $employee_positions = EmployeePosition::all();

        $user_location_access  = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
        $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
        $available_salespoints = $available_salespoints->groupBy('region');

        $formperpanjangan_authorizations = Authorization::where('salespoint_id',$armadaticket->salespoint_id)
        ->where('form_type',6)
        ->get();
        try { 
            if(!$armadaticket){
                throw new \Exception('Ticket armada dengan kode '.$code.'tidak ditemukan');
            }
            return view('Operational.Armada.armadaticketdetail',compact('armadaticket','employee_positions','available_salespoints','formperpanjangan_authorizations'));
        } catch (\Exception $ex) {
            return redirect('/ticketing')->with('error','Gagal membukan detail ticket armada '.$ex->getMessage());
        }
    }
}
