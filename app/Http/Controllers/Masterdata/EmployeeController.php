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
use Carbon\Carbon;

use App\Models\EmployeePosition;
use App\Models\Employee;
use App\Models\AuthorizationDetail;

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
            return back()->with('error','Gagal mengubah jabatan, silahkan coba kembali atau hubungi developer "'.$ex->getMessage().'"');
        }
    }
    public function deleteEmployeePosition(Request $request){
        try {
            $position           = EmployeePosition::findOrFail($request->position_id);
            $position->delete();
            return back()->with('success','Berhasil menghapus jabatan '.$position->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal menghapus jabatan, silahkan coba kembali atau hubungi developer "'.$ex->getMessage().'"');
        }
    }

    // EMPLOYEE
    public function employeeView(){
        $employees = Employee::where('id','!=',1)->get();
        return view('Masterdata.employee',compact('employees'));
    }

    public function addEmployee(Request $request){
        try {
            $count_employee = Employee::withTrashed()->count() + 1;
            $code = "EMP-".str_repeat("0", 4-strlen($count_employee)).$count_employee;

            $checkEmployee = Employee::where('username',$request->username)->first();
            if($checkEmployee){
                return back()->with('error','Username sudah terdaftar sebelum untuk karyawan dengan nama '.$checkEmployee->name);
            }
            $checkEmployee = Employee::where('email',$request->email)->first();
            if($checkEmployee){
                return back()->with('error','Email sudah terdaftar sebelum untuk karyawan dengan nama '.$checkEmployee->name);
            }

            $newEmployee                         = new Employee;
            $newEmployee->code                   = $code;
            $newEmployee->name                   = $request->name;
            $newEmployee->username               = $request->username;
            $newEmployee->email                  = $request->email;
            $newEmployee->password               = Hash::make($request->password);
            $newEmployee->phone                  = $request->phone;
            $newEmployee->save();
            return back()->with('success','Berhasil menambahkan karyawan '.$request->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal menambahkan karyawan, silahkan coba kembali atau hubungi developer "'.$ex->getMessage().'"');
        }
        
    }

    public function updateEmployee(Request $request){
        try {
            $employee             = Employee::findOrFail($request->employee_id);
            $check_is_email_exist = Employee::where('email',$request->email)->first();
            if($check_is_email_exist && ($employee->email != $request->email)){
                return back()->with('error','Email '.$request->email.' telah terdaftar sebelumnya dengan nama pengguna '.$check_is_email_exist->name);
            }
            $employee->phone                = $request->phone;
            $employee->name                 = $request->name;
            $employee->email                = $request->email;
            $employee->save();
            return back()->with('success','Berhasil memperbarui data karyawan '.$request->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal memperbarui data karyawan, silahkan coba kembali atau hubungi developer "'.$ex->getMessage().'"');
        }
    }

    public function activeEmployee(Request $request){
        try{
            $employee =  Employee::findOrFail($request->employee_id);
            if(new Carbon($employee->updated_at) != new Carbon($request->updated_at)){
                return back()->with('error','Employee sudah di update sebelumnya. Silahkan coba kembali.');
            }
            $employee->status = 0;
            $employee->save();
            return back()->with('success','berhasil diaktifkan');
        }catch (\Exception $ex){
            return back()->with('error','Gagal mengaktifkan karyawan, silahkan coba kembali atau hubungi developer "'.$ex->getMessage().'"');
        }
    }

    public function nonactiveEmployee(Request $request){
        try{
            $employee           = Employee::findOrFail($request->employee_id);
            if(new Carbon($employee->updated_at) != new Carbon($request->updated_at)){
                return back()->with('error','Employee sudah di update sebelumnya. Silahkan coba kembali.');
            }
            $employee->status   = 1;
            $employee->save();
            return back()->with('success','berhasil di non aktifkan');
        }catch (\Exception $ex){
            return back()->with('error','Gagal mengaktifkan karyawan, silahkan coba kembali atau hubungi developer "'.$ex->getMessage().'"');
        }
    }

    public function deleteEmployee(Request $request){
        try{
            $employee           = Employee::findOrFail($request->employee_id);
            if(new Carbon($employee->updated_at) != new Carbon($request->updated_at)){
                return back()->with('error','Employee sudah di update sebelumnya. Silahkan coba kembali.');
            }
            $employee->delete();
            return back()->with('success','Karyawan berhasil dihapus');
        }catch (\Exception $ex){
            return back()->with('error','Gagal menghapus karyawan, silahkan coba kembali atau hubungi developer "'.$ex->getMessage().'"');
        }
    }

}
