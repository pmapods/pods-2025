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

use App\Models\EmployeePosition;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // EMPLOYEE POSITION
    public function employeepostitionView(){
        $positions = EmployeePosition::whereNotIn('id',[1])->get();
        return view('Masterdata.employeeposition',compact('positions'));
    }
    public function addEmployeePosition(Request $request){
        $newPosition            = new EmployeePosition;
        $newPosition->name      = $request->name;
        $newPosition->save();
        return back()->with('success','Berhasil menambahkan jabatan '.$request->name);
    }
    public function updateEmployeePosition(Request $request){
        try {
            $position           = EmployeePosition::findOrFail($request->position_id);
            $old_name           = $position->name;
            $position->name     = $request->name;
            $position->save();
            return back()->with('success','Berhasil menguban jabatan '.$old_name.' menjadi '.$position->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal mengubah jabatan, silahkan coba kembali atau hubungi admin');
        }
    }
    public function deleteEmployeePosition(Request $request){
        try {
            $position           = EmployeePosition::findOrFail($request->position_id);
            $position->delete();
            return back()->with('success','Berhasil menghapus jabatan '.$position->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal menghapus jabatan, silahkan coba kembali atau hubungi admin');
        }
    }

    // EMPLOYEE
    public function employeeView(){
        $employees = Employee::whereNotIn('employee_position_id',[1])->get();;
        $positions = EmployeePosition::whereNotIn('id',[1])->get();
        return view('Masterdata.employee',compact('employees','positions'));
    }

    public function addEmployee(Request $request){
        try {
            $count_employee = Employee::withTrashed()->count() + 1;
            $code = "EMP-".str_repeat("0", 4-strlen($count_employee)).$count_employee;

            $newEmployee                         = new Employee;
            $newEmployee->employee_position_id   = $request->position;
            $newEmployee->code                   = $code;
            $newEmployee->name                   = $request->name;
            $newEmployee->username               = $request->username;
            $newEmployee->email                  = $request->email;
            $newEmployee->password               = Hash::make($request->password);
            $newEmployee->phone                  = $request->phone;
            $newEmployee->save();
            return back()->with('success','Berhasil menambahkan karyawan '.$request->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal menambahkan karyawan, silahkan coba kembali atau hubungi admin');
        }
        
    }

    public function updateEmployee(Request $request){
        try {
            $employee                       = Employee::findOrFail($request->employee_id);
            $employee->employee_position_id = $request->position;
            $employee->phone                = $request->phone;
            $employee->name                 = $request->name;
            $employee->save();
            return back()->with('success','Berhasil memperbarui data karyawan '.$request->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal memperbarui data karyawan, silahkan coba kembali atau hubungi admin');
        }
    }

    public function activeEmployee(Request $request){
        try{
            $employee =  Employee::findOrFail($request->employee_id);
            $employee->status = 0;
            $employee->save();
            return back()->with('success','berhasil diaktifkan');
        }catch (\Exception $ex){
            return back()->with('error','Gagal mengaktifkan karyawan, silahkan coba kembali atau hubungi admin');
        }
    }

    public function nonactiveEmployee(Request $request){
        try{
            $employee           = Employee::findOrFail($request->employee_id);
            $employee->status   = 1;
            $employee->save();
            return back()->with('success','berhasil di non aktifkan');
        }catch (\Exception $ex){
            return back()->with('error','Gagal mengaktifkan karyawan, silahkan coba kembali atau hubungi admin');
        }
    }

}
