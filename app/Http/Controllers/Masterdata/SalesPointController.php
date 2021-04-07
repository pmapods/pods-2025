<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SalesPoint;

class SalesPointController extends Controller
{
    public function salespointView(){
        $salespoints = SalesPoint::all();
        return view('Masterdata.salespoint',compact('salespoints'));
    }
}
