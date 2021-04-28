<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BiddingController extends Controller
{
    public function biddingView(){
        return view('Operational.bidding');
    }

    public function biddingDetailView(){
        return view('Operational.biddingdetail');
    }
}
