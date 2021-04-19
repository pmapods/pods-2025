<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeLocationAccess;
use App\Models\SalesPoint;
use App\Models\BudgetPricingCategory;
use Auth;

class TicketingController extends Controller
{
    public function ticketingView(){
        $user_location_access = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
        $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
        $available_salespoints = $available_salespoints->groupBy('region');
        
        $budget_category_items = BudgetPricingCategory::all();
        return view('Operational.ticketing',compact('available_salespoints','budget_category_items'));
    }
}
