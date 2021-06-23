<?php

namespace App\Http\Controllers\Monitoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;

class MonitoringController extends Controller
{
    public function ticketMonitoringView(){
        $tickets = Ticket::whereNotIn('status',[-1])->get();
        return view('Monitoring.ticketmonitoring',compact('tickets'));
    }
}
