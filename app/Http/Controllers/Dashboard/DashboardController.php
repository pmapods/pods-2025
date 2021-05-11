<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardView(){
        // check if already change password
        return view('Dashboard.dashboard');
    }
}
