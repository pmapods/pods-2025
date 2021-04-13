<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SalesPoint;
use App\Models\Employee;
use App\Models\EmployeeLocationAccess;

class EmployeeAccessController extends Controller
{
    public function employeeAccessView(){
        $employees = Employee::whereNotIn('id',[1])->get();
        return view('Masterdata.employeeaccess',compact('employees'));
    }

    public function employeeaccessdetailView($employee_code){
        $employee = Employee::where('code',$employee_code)->first();
        $salespoints = SalesPoint::all();
        $regions = $salespoints->groupBy('region');
        return view('Masterdata.employeeaccessdetail',compact('employee','regions'));
    }

    public function updateemployeeaccessdetail(Request $request){
        try {
            $old_access = EmployeeLocationAccess::where('employee_id',$request->employee_id)->get();
            if($old_access){
                foreach($old_access as $access){
                    $access->delete();
                }
            }
            foreach($request->location as $access){
                $newAccess = new EmployeeLocationAccess;
                $newAccess->employee_id = $request->employee_id;
                $newAccess->salespoint_id = $access;
                $newAccess->save();
            }
            return redirect('/employeeaccess')->with('success','Berhasil update data akses karyawan');
        } catch (\Exception $ex) {
            dd($ex);
            return redirect('/employeeaccess')->with('error','Gagal update data akses karyawan');
        }
        

    }
}
