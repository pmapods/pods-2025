<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketMonitoring;

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
}
