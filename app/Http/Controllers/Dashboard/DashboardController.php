<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardView(){
        // dd('im on dashboard controller');
        return view('Dashboard.dashboard');
    }
}
