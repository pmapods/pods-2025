<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Province;
use App\Models\Regency;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function vendorView(){
        $regency = Regency::inRandomOrder()->first()->name;
        $vendors = Vendor::all();
        $provinces = Province::all();
        return view('Masterdata.vendor',compact('provinces','vendors'));
    }

    public function addVendor(Request $request){
        try{
            $check = Vendor::where('code',$request->code)->first();
            if($check!=null){
                return back()->with('error','Kode vendor tidak bisa sama / harus berbeda -- '.$request->code.' '.$check->name);
            }
            $newVendor              = new Vendor;
            $newVendor->code        = $request->code;
            $newVendor->name        = $request->name;
            $newVendor->address     = $request->address;
            $newVendor->city_id     = $request->city_id;
            $newVendor->salesperson = $request->salesperson;
            $newVendor->phone       = $request->phone;
            $newVendor->save();
            return back()->with('success','Berhasil menambahkan vendor');
        }catch (\Exception $ex) {
            return back()->with('error','Gagal menambahkan Vendor  "'.$ex->getMessage().'"');
        }
    }

    public function updateVendor(Request $request){
        try{
            $vendor = Vendor::findOrFail($request->id);
            $vendor->address     = $request->address;
            $vendor->city_id     = $request->city_id;
            $vendor->salesperson = $request->salesperson;
            $vendor->phone       = $request->phone;
            $vendor->save();

            return back()->with('success','Berhasil memperbarui vendor');
        }catch (\Exception $ex) {
            return back()->with('error','Gagal memperbarui Vendor  "'.$ex->getMessage().'"');
        }
    }

    public function deleteVendor(Request $request){
        try{
            $vendor = Vendor::findOrFail($request->id);
            $vendor->delete();

            return back()->with('success','Berhasil menghapus vendor');
        }catch (\Exception $ex) {
            return back()->with('error','Gagal menghapus Vendor  "'.$ex->getMessage().'"');
        }
    }
}
