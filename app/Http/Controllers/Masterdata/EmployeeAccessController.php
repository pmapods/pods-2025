<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeAccessController extends Controller
{
    public function employeeAccessView(){
        return view('Masterdata.employeeaccess');
    }

    public function employeeaccessdetailView($employee_code){
        return view('Masterdata.employeeaccessdetail',compact('employee_code'));

    }
}
