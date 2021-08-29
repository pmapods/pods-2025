<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\EmployeeLocationAccess;
use App\Models\SalesPoint;

class BudgetUploadController extends Controller
{
    public function inventoryBudgetView(){
        return view('Budget.inventorybudget');
    }

    public function addInventoryBudgetView(){
        $user_location_access  = EmployeeLocationAccess::where('employee_id',Auth::user()->id)->get()->pluck('salespoint_id');
        $available_salespoints = SalesPoint::whereIn('id',$user_location_access)->get();
        $available_salespoints = $available_salespoints->groupBy('region');
        return view('Budget.addinventorybudget',compact('available_salespoints'));
    }
}
