<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SalesPoint;
use App\Models\Employee;
use App\Models\EmployeeLocationAccess;
use App\Models\EmployeeMenuAccess;

use DB;

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
            DB::beginTransaction();
            $old_access = EmployeeLocationAccess::where('employee_id',$request->employee_id)->get();
            if($old_access){
                foreach($old_access as $access){
                    $access->delete();
                }
            }
            if($request->location!=null){
                foreach($request->location as $access){
                    $newAccess = new EmployeeLocationAccess;
                    $newAccess->employee_id = $request->employee_id;
                    $newAccess->salespoint_id = $access;
                    $newAccess->save();
                }
            }

            $old_menu_access = EmployeeMenuAccess::where('employee_id',$request->employee_id)->first();
            if(!$old_menu_access){
                $old_menu_access =  new EmployeeMenuAccess;
                $old_menu_access->employee_id = $request->employee_id;
            }
            // dd( array_sum($request->masterdata));
            $old_menu_access->masterdata = array_sum($request->masterdata ?? []);
            $old_menu_access->budget = array_sum($request->budget ?? []);
            $old_menu_access->operational = array_sum($request->operational ?? []);
            $old_menu_access->monitoring = array_sum($request->monitoring ?? []);
            $old_menu_access->save();
            DB::commit();
            return redirect('/employeeaccess')->with('success','Berhasil update data akses karyawan');
        } catch (Exception $ex) {
            DB::rollback();
            return redirect('/employeeaccess')->with('error','Gagal update data akses karyawan "'.$ex->getMessage().'"');
        }
        

    }
}
