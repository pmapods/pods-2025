<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\ArmadaTicket;
use App\Models\TicketMonitoring;
use App\Models\Po;

class MonitoringController extends Controller
{
    public function ticketMonitoringView(){
        $tickets = Ticket::whereNotIn('status',[-1])->get();
        // dd($tickets);
        return view('Monitoring.ticketmonitoring',compact('tickets'));
    }
    
    public function ticketMonitoringLogs($ticket_id){
        $logs = TicketMonitoring::where('ticket_id',$ticket_id)
        ->get()
        ->sortBy('created_at');
        $ticket = Ticket::find($ticket_id);
        $data = [];
        foreach($logs as $log){
            $item = new \stdClass();
            $item->message = $log->message;
            $item->employee_name = $log->employee_name;
            $item->date = $log->created_at->translatedFormat('d F Y (H:i)');
            array_push($data, $item);
        }
        return response()->json([
            'data' => $data,
            'status' =>  $ticket->status(),
        ]);
    }

    public function armadaMonitoringView(){
        // cari po yang statusnya sedang aktif saat ini
        $pos = Po::whereIn('status',[3])->get();
        $end_kontrak_tickets = ArmadaTicket::join('perpanjangan_form','armada_ticket.id','=','perpanjangan_form.armada_ticket_id')
                            ->where('perpanjangan_form.stopsewa_reason',"end")
                            ->where('armada_ticket.status',6)
                            ->get();
        
        return view('Monitoring.armadamonitoring',compact('pos','end_kontrak_tickets'));
    }

    public function armadaMonitoringLogs($po_number){
        $po = Po::where('no_po_sap',$po_number)->first();
        $pos = [$po->no_po_sap];
        $flag = true;
        $reference_armada_ticket = ArmadaTicket::where('po_reference_number',$po_number)->first();
        $prev_po_number = $po->armada_ticket->po_reference_number;
        do{
            if($prev_po_number == null){
                $flag = false;
            }else{
                $prev_po = Po::where('no_po_sap',$prev_po_number)->first();
                array_push($pos,$prev_po->no_po_sap);
                $prev_po_number = $prev_po->armada_ticket->po_reference_number;
            }
        }while($flag);
        $data = [];
        if($reference_armada_ticket != null){
            $temp = new \stdClass();
            $temp->po_number = '-';
            $temp->date = $reference_armada_ticket->updated_at->translatedFormat('d F Y');
            $temp->type = $reference_armada_ticket->type();
            array_push($data,$temp);
        }
        foreach($pos as $po_number){
            $po = Po::where('no_po_sap',$po_number)->first();
            $temp = new \stdClass();
            $temp->po_number = $po->no_po_sap;
            $temp->date = $po->created_at->translatedFormat('d F Y');
            $temp->type = $po->armada_ticket->type();
            array_push($data,$temp);
        }
        return response()->json([
            'data' => $data,
        ]);
    }
}
