<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketingController extends Controller
{
    public function ticketingView(){
        return view('Operational.ticketing');
    }
}
