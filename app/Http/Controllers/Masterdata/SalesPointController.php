<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SalesPoint;

class SalesPointController extends Controller
{
    public function salespointView()
    {
        $salespoints = SalesPoint::all();
        return view('Masterdata.salespoint', compact('salespoints'));
    }
    
    public function addSalesPoint(Request $request)
    {
        try{
            $checksalespoint = SalesPoint::where('code', $request->code)->first();
            if($checksalespoint){
                return back()->with('error','Kode sales point sudah terdaftar ('.$checksalespoint->name.'('.$checksalespoint->region_name().')'.')');
            }else{
                $newSalesPoint = new SalesPoint;
                $newSalesPoint->code           = $request->code;
                $newSalesPoint->name           = $request->name;
                $newSalesPoint->region         = $request->region;
                $newSalesPoint->status         = $request->status;
                $newSalesPoint->trade_type     = $request->trade_type;
                $newSalesPoint->isJawaSumatra  = $request->isJawaSumatra;
                $newSalesPoint->grom           = $request->grom;
                $newSalesPoint->save();
                return back()->with('success','Sales Point berhasil terdaftar ('.$newSalesPoint->name.'('.$newSalesPoint->region_name().')'.')');
            }
        }catch (\Exception $ex) {
            return back()->with('error','Gagal menambahkan salespoint, silahkan coba kembali atau hubungi admin "'.$ex->getMessage().'"');
        }
    }

    public function updateSalesPoint(Request $request){
        try {
            $salespoint                 = SalesPoint::findOrFail($request->salespoint_id);
            $salespoint->code           = $request->code;
            $salespoint->name           = $request->name;
            $salespoint->region         = $request->region;
            $salespoint->status         = $request->status;
            $salespoint->trade_type     = $request->trade_type;
            $salespoint->isJawaSumatra  = $request->isJawaSumatra;
            $salespoint->grom           = $request->grom;
            $salespoint->save();
            return back()->with('success','Berhasil memperbarui data sales point '.$request->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal memperbarui data salespoint, silahkan coba kembali atau hubungi admin "'.$ex->getMessage().'"');
        }
    }
    public function deleteSalesPoint(Request $request){
        try {
            $salespoint           = Salespoint::findOrFail($request->salespoint_id);
            $salespoint->delete();
            return back()->with('success','Berhasil menghapus salespoint '.$salespoint->name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal menghapus salespoint, silahkan coba kembali atau hubungi admin "'.$ex->getMessage().'"');
        }
    }
}