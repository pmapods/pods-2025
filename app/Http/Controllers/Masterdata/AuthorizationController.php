<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesPoint;
use App\Models\Employee;
use App\Models\EmployeePosition;
use App\Models\EmployeeLocationAccess;
use App\Models\Authorization;
use App\Models\AuthorizationDetail;
use DB;

class AuthorizationController extends Controller
{
    public function authorizationView(){
        $salespoints = SalesPoint::all();
        $regions = $salespoints->groupBy('region');
        $positions = EmployeePosition::where('id','!=',1)->get();
        $authorizations = Authorization::all();
        return view('Masterdata.authorization',compact('regions','authorizations','positions'));
    }

    public function addAuthorization(Request $request){
        try {
            DB::beginTransaction();
            switch ($request->form_type) {
                case '0':
                    // 0 form pengadaan barang jasa
                    $detail_counts = [3];
                    $errMessage = "Form Pengadaan Barang jasa membutuhkan 3 opilihan torisasi";
                    break;
                case '1':
                    // 1 form bidding
                    $detail_counts = [3];
                    $errMessage = "Form Bidding membutuhkan 3 pilihan otorisasi";
                    break;
                case '2':
                    // 2 form pr
                    $detail_counts = [3,4];
                    $errMessage = "Form PR membutuhkan 3 atau 4 pilihan otorisasi";
                    break;
                case '3':
                    // 3 form po
                    $detail_counts = [2];
                    $errMessage = "Form PO membutuhkan 2 pilihan otorisasi";
                    break;
                case '4':
                    // 4 form fasilitas
                    $detail_counts = [2];
                    $errMessage = "Form Fasilitas membutuhkan 2 pilihan otorisasi";
                    break;
                case '5':
                    // 5 form mutasi
                    $detail_counts = [7];
                    $errMessage = "Form Mutasi membutuhkan 7 pilihan otorisasi";
                    break;
                case '6':
                    // 6 form perpanjangan perhentian
                    $detail_counts = [4,5];
                    $errMessage = "Form Perpanjangan Perhentian membutuhkan 4 atau 5 pilihan otorisasi";
                    break;
                case '7':
                    // 7 form pengadaan armada
                    $detail_counts = [3];
                    $errMessage = "Form Pengadaan Armada membutuhkan 3 pilihan otorisasi";
                    break;
                case '8':
                    // 8 form pengadaan security
                    $detail_counts = [3];
                    $errMessage = "Form Pengadaan Security membutuhkan 3 pilihan otorisasi";
                    break;
                case '9':
                    // 9 form evaluasi
                    $detail_counts = [4];
                    $errMessage = "Form Evaluasi membutuhkan 4 pilihan otorisasi";
                    break;
                case '10':
                    // 10 upload budget
                    $detail_counts = [2,3,4,5];
                    $errMessage = "Form Evaluasi membutuhkan minimal 1 pilihan otorisasi";
                    break;
            }
            if($detail_counts != -1){
                if(!in_array(count($request->authorization),$detail_counts)){
                    return back()->with('error',$errMessage);
                }
            }

            $newAuthorization                 = new Authorization;
            $newAuthorization->salespoint_id  = $request->salespoint;
            $newAuthorization->form_type      = $request->form_type;
            $newAuthorization->save();
            foreach ($request->authorization as $data){
                $detail                         = new AuthorizationDetail;
                $detail->authorization_id       = $newAuthorization->id;
                $detail->employee_id            = $data['id'];
                $detail->employee_position_id   = $data['position'];
                $detail->sign_as                = $data['as'];
                $detail->level                  = $data['level'];
                $detail->save();
            }
            DB::commit();
            return back()->with('success', 'Berhasil menambahkan otorisasi untuk salespoint');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal membuat otorisasi "'.$ex->getMessage().'"');
        }
    }

    public function updateAuthorization(Request $request){
        try {
            DB::beginTransaction();
            
            switch ($request->form_type) {
                case '0':
                    // 0 form pengadaan barang jasa
                    $detail_counts = [3];
                    $errMessage = "Form Pengadaan Barang jasa membutuhkan 3 opilihan torisasi";
                    break;
                case '1':
                    // 1 form bidding
                    $detail_counts = [3];
                    $errMessage = "Form Bidding membutuhkan 3 pilihan otorisasi";
                    break;
                case '2':
                    // 2 form pr
                    $detail_counts = [3,4];
                    $errMessage = "Form PR membutuhkan 3 atau 4 pilihan otorisasi";
                    break;
                case '3':
                    // 3 form po
                    $detail_counts = [2];
                    $errMessage = "Form PO membutuhkan 2 pilihan otorisasi";
                    break;
                case '4':
                    // 4 form fasilitas
                    $detail_counts = [2];
                    $errMessage = "Form Fasilitas membutuhkan 2 pilihan otorisasi";
                    break;
                case '5':
                    // 5 form mutasi
                    $detail_counts = [7];
                    $errMessage = "Form Mutasi membutuhkan 7 pilihan otorisasi";
                    break;
                case '6':
                    // 6 form perpanjangan perhentian
                    $detail_counts = [4,5];
                    $errMessage = "Form Perpanjangan Perhentian membutuhkan 4 atau 5 pilihan otorisasi";
                    break;
                case '7':
                    // 7 form pengadaan armada
                    $detail_counts = [3];
                    $errMessage = "Form Pengadaan Armada membutuhkan 3 pilihan otorisasi";
                    break;
                case '8':
                    // 8 form pengadaan security
                    $detail_counts = [3];
                    $errMessage = "Form Pengadaan Security membutuhkan 3 pilihan otorisasi";
                    break;
                case '9':
                    // 9 form evaluasi
                    $detail_counts = [4];
                    $errMessage = "Form Evaluasi membutuhkan 4 pilihan otorisasi";
                    break;
                case '10':
                    // 10 upload budget
                    $detail_counts = [2,3,4,5];
                    $errMessage = "Form Evaluasi membutuhkan minimal 1 pilihan otorisasi";
                    break;
            }
            
            if($detail_counts != -1){
                if(!in_array(count($request->authorization),$detail_counts)){
                    return back()->with('error',$errMessage);
                }
            }
            
            $authorization = Authorization::findOrFail($request->authorization_id);
            $authorization->salespoint_id  = $request->salespoint;
            $authorization->form_type      = $request->form_type;
            $authorization->save();

            foreach ($authorization->authorization_detail as $old){
                $old->delete();
            }
            foreach ($request->authorization as $data){
                $detail                         = new AuthorizationDetail;
                $detail->authorization_id       = $authorization->id;
                $detail->employee_id            = $data['id'];
                $detail->employee_position_id   = $data['position'];
                $detail->sign_as                = $data['as'];
                $detail->level                  = $data['level'];
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
            $authorization = Authorization::findOrFail($request->authorization_id);
            foreach ($authorization->authorization_detail as $old){
                $old->delete();
            }
            $authorization->delete();
            DB::commit();
            return back()->with('success','Berhasil menghapus otorasi');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal menghapus otorisasi "'.$ex->getMessage().'"');
        }
    }

    public function AuthorizedEmployeeBySalesPoint($salespoint_id){
        $employeeaccess = EmployeeLocationAccess::where('salespoint_id',$salespoint_id)
        ->where('employee_id','!=',1)
        ->get();
        $employees = $employeeaccess->pluck('employee_id');
        $data = array();
        foreach($employees as $employee){
            $selected_employee = Employee::find($employee);
            if($selected_employee != null){
                $single_data = (object)[];
                $single_data->id = $selected_employee->id;
                $single_data->name = $selected_employee->name;
                if($selected_employee->status == 0){
                    array_push($data,$single_data);
                }
            }
        }
        return response()->json([
            'salespoint_id' => $salespoint_id,
            'data' => $data
        ]);
    }
}
