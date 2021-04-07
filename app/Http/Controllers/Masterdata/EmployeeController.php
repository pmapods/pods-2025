<?php

namespace App\Http\Controllers\Masterdata;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Validator;
use Redirect;
use Crypt;
use Auth;
use Hash;
use DB;

class EmployeeController extends Controller
{
    public function employeeView(){
        return view('Masterdata.employee');
    }
    public function employeepostitionView(){
        return view('Masterdata.employeeposition');
    }
}
