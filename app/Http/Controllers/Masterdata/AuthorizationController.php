<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesPoint;

class AuthorizationController extends Controller
{
    public function authorizationView(){
        $salespoints = SalesPoint::all();
        $regions = $salespoints->groupBy('region');
        return view('Masterdata.authorization',compact('regions'));
    }
}
