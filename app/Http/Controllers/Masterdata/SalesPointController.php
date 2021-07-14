<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SalesPoint;
use App\Models\EmployeeLocationAccess;
use App\Models\Employee;
use App\Models\Authorization;

class SalesPointController extends Controller
{
    public function salespointView(){
        $salespoints = SalesPoint::all();
        return view('Masterdata.salespoint', compact('salespoints'));
    }
    
    public function addSalesPoint(Request $request){
        try{
            $checksalespoint = SalesPoint::where('code', $request->code)->first();
            if($checksalespoint){
                return back()->with('error','Kode sales point sudah terdaftar '.$checksalespoint->name.' -- '.$checksalespoint->region_name());
            }else{
                $newSalesPoint = new SalesPoint;
                $newSalesPoint->code           = $request->code;
                $newSalesPoint->name           = $request->name;
                $newSalesPoint->initial        = $request->initial;
                $newSalesPoint->region         = $request->region;
                $newSalesPoint->status         = $request->status;
                $newSalesPoint->trade_type     = $request->trade_type;
                $newSalesPoint->isJawaSumatra  = $request->isJawaSumatra;
                $newSalesPoint->address        = $request->address ?? null;
                $newSalesPoint->save();

                // give new salespoint access to admin
                $newAccess = new EmployeeLocationAccess;
                $newAccess->employee_id = 1;
                $newAccess->salespoint_id = $newSalesPoint->id;
                $newAccess->save();

                return back()->with('success','Sales Point berhasil terdaftar '.$newSalesPoint->name.' -- '.$newSalesPoint->region_name());
            }
        }catch (\Exception $ex) {
            return back()->with('error','Gagal menambahkan salespoint, silahkan coba kembali atau hubungi developer "'.$ex->getMessage().'"');
        }
    }

    public function updateSalesPoint(Request $request){
        try {
            $salespoint                 = SalesPoint::findOrFail($request->salespoint_id);
            $salespoint->code           = $request->code;
            $salespoint->name           = $request->name;
            $salespoint->initial        = $request->initial;
            $salespoint->region         = $request->region;
            $salespoint->status         = $request->status;
            $salespoint->trade_type     = $request->trade_type;
            $salespoint->isJawaSumatra  = $request->isJawaSumatra;
            $salespoint->address        = $request->address ?? null;
            $salespoint->save();
            return back()->with('success','Berhasil memperbarui data sales point '.$request->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal memperbarui data salespoint, silahkan coba kembali atau hubungi developer "'.$ex->getMessage().'"');
        }
    }

    public function deleteSalesPoint(Request $request){
        try {
            $salespoint           = SalesPoint::findOrFail($request->salespoint_id);
            $salespoint->delete();

            // remove semua akses di salespoint terkait
            $salespoint_access = EmployeeLocationAccess::where('salespoint_id',$request->salespoint_id)->get();
            foreach($salespoint_access as $access){
                $access->delete();
            }

            return back()->with('success','Berhasil menghapus salespoint '.$salespoint->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal menghapus salespoint, silahkan coba kembali atau hubungi developer "'.$ex->getMessage().'"');
        }
    }

    public function getSalesAuthorization($salespoint_id) {
        $authorizations = Authorization::where('salespoint_id',$salespoint_id)
        ->where('form_type',0)
        ->get();
        $data = array();
        foreach($authorizations as $authorization){
            $single_data = (object)[];
            $single_data->id = $authorization->id;
            $single_data->detail = array();
            foreach($authorization->authorization_detail->sortBy('level') as $detail){
                $single_detail = (object)[];
                $single_detail->name = $detail->employee->name;
                $single_detail->position = $detail->employee_position->name;
                $single_detail->as = $detail->sign_as;
                $single_detail->level = $detail->level;
                array_push($single_data->detail,$single_detail);
            }
            array_push($data,$single_data);
        }
        return response()->json([
            'data' => $data
        ]);
    }
}