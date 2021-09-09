<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\ArmadaTicket;
use App\Models\SecurityTicket;
use App\Models\TicketMonitoring;
use App\Models\ArmadaTicketMonitoring;
use App\Models\SecurityTicketMonitoring;
use App\Models\Po;

class MonitoringController extends Controller
{
    public function ticketMonitoringView(){
        $tickets = Ticket::whereNotIn('status',[-1])->get();
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
            'status' =>  $ticket->status() ?? null,
        ]);
    }

    public function armadaMonitoringView(){
        $tickets = ArmadaTicket::whereNotIn('status',[-1])->get();
        // cari po yang statusnya sedang aktif saat ini
        $pos = Po::whereIn('status',[3])
        ->where('armada_ticket_id','!=',null)
        ->get();
        $end_kontrak_tickets = ArmadaTicket::join('perpanjangan_form','armada_ticket.id','=','perpanjangan_form.armada_ticket_id')
            ->where('perpanjangan_form.stopsewa_reason',"end")
            ->where('armada_ticket.status',6)
            ->get();
        
        return view('Monitoring.armadamonitoring',compact('pos','end_kontrak_tickets','tickets'));
    }

    public function armadaMonitoringTicketLogs($code){
        $armadaticket = ArmadaTicket::where('code',$code)->first();
        $logs = ArmadaTicketMonitoring::where('armada_ticket_id',$armadaticket->id)
        ->get()
        ->sortBy('created_at');
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
            'status' =>  $armadaticket->status(),
        ]);
    }

    public function armadaMonitoringPOLogs($po_number){
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
    
    public function securityMonitoringView(){
        $tickets = SecurityTicket::whereNotIn('status',[-1])->get();
        // cari po yang statusnya sedang aktif saat ini
        $pos = Po::whereIn('status',[3])
        ->where('security_ticket_id','!=',null)
        ->get();
        $end_kontrak_tickets = SecurityTicket::where('ticketing_type',3)
            ->where('security_ticket.status',6)
            ->get();
        
        return view('Monitoring.securitymonitoring',compact('pos','end_kontrak_tickets','tickets'));
    }

    public function securityMonitoringTicketLogs($code){
        $securityticket = SecurityTicket::where('code',$code)->first();
        $logs = SecurityTicketMonitoring::where('security_ticket_id',$securityticket->id)
        ->get()
        ->sortBy('created_at');
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
            'status' =>  $securityticket->status() ?? null,
        ]);
    }

    public function securityMonitoringPOLogs($po_number){
        $po = Po::where('no_po_sap',$po_number)->first();
        $pos = [$po->no_po_sap];
        $flag = true;
        $reference_security_ticket = SecurityTicket::where('po_reference_number',$po_number)->first();
        $prev_po_number = $po->security_ticket->po_reference_number;
        do{
            if($prev_po_number == null){
                $flag = false;
            }else{
                $prev_po = Po::where('no_po_sap',$prev_po_number)->first();
                array_push($pos,$prev_po->no_po_sap);
                $prev_po_number = $prev_po->security_ticket->po_reference_number;
            }
        }while($flag);
        $data = [];
        if($reference_security_ticket != null){
            $temp = new \stdClass();
            $temp->po_number = '-';
            $temp->date = $reference_security_ticket->updated_at->translatedFormat('d F Y');
            $temp->type = $reference_security_ticket->type();
            array_push($data,$temp);
        }
        foreach($pos as $po_number){
            $po = Po::where('no_po_sap',$po_number)->first();
            $temp = new \stdClass();
            $temp->po_number = $po->no_po_sap;
            $temp->date = $po->created_at->translatedFormat('d F Y');
            $temp->type = $po->security_ticket->type();
            array_push($data,$temp);
        }
        return response()->json([
            'data' => $data,
        ]);
    }
}
