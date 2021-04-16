<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesPoint;
use App\Models\Employee;
use App\Models\EmployeeLocationAccess;
use App\Models\Authorization;
use App\Models\AuthorizationDetail;
use DB;

class AuthorizationController extends Controller
{
    public function authorizationView(){
        $salespoints = SalesPoint::all();
        $regions = $salespoints->groupBy('region');
        $authorizations = Authorization::all();
        return view('Masterdata.authorization',compact('regions','authorizations'));
    }

    public function addAuthorization(Request $request){
        try {
            DB::beginTransaction();
            $newAuthorization                 = new Authorization;
            $newAuthorization->salespoint_id  = $request->salespoint;
            $newAuthorization->form_type      = $request->form_type;
            $newAuthorization->save();
            foreach ($request->authorization as $data){
                $detail                    = new AuthorizationDetail;
                $detail->authorization_id  = $newAuthorization->id;
                $detail->employee_id       = $data['id'];
                $detail->sign_as           = $data['as'];
                $detail->level             = $data['level'];
                $detail->save();
            }
            DB::commit();
            return back()->with('success', 'Berhasil menambahkan otorisasi untuk salespoint');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal membuat otorisasi');
        }
    }

    public function updateAuthorization(Request $request){
        try {
            DB::beginTransaction();
            $authorization = Authorization::findOrFail($request->authorization_id);
            $authorization->salespoint_id  = $request->salespoint;
            $authorization->form_type      = $request->form_type;
            $authorization->save();

            foreach ($authorization->authorization_detail as $old){
                $old->delete();
            }
            foreach ($request->authorization as $data){
                $detail                    = new AuthorizationDetail;
                $detail->authorization_id  = $authorization->id;
                $detail->employee_id       = $data['id'];
                $detail->sign_as           = $data['as'];
                $detail->level             = $data['level'];
                $detail->save();
            }
            DB::commit();
            return back()->with('success', 'Berhasil update otorisasi');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal update otorisasi "'.$ex->getMessage().'"');
        }
    }

    public function deleteAuthorization(Request $request){
        try {
            DB::beginTransaction();
            $authorization = Authorization::find($request->authorization_id);
            $authorization->authorization_detail->delete();
            $authorization->delete();
            DB::commit();
            return back()->with('success','Berhasil menghapus otorasi');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal menghapus otorisasi');
        }
    }

    public function AuthorizedEmployeeBySalesPoint($salespoint_id){
        $employeeaccess = EmployeeLocationAccess::where('salespoint_id',$salespoint_id)->get();
        $employees = $employeeaccess->pluck('employee_id');
        $data = array();
        foreach($employees as $employee){
            $selected_employee = Employee::find($employee);
            $single_data = (object)[];
            $single_data->id = $selected_employee->id;
            $single_data->name = $selected_employee->name;
            $single_data->position = $selected_employee->employee_position->name;
            array_push($data,$single_data);
        }
        return response()->json([
            'salespoint_id' => $salespoint_id,
            'data' => $data
        ]);
    }
}
