<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SalesPoint;

class EmployeeAccessController extends Controller
{
    public function employeeAccessView(){
        return view('Masterdata.employeeaccess');
    }

    public function employeeaccessdetailView($employee_code){
        $salespoints = SalesPoint::all();
        $regions = $salespoints->groupBy('region');
        return view('Masterdata.employeeaccessdetail',compact('employee_code','regions'));

    }
}
