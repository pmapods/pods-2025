<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Province;
use App\Models\Regency;
use App\Models\Vendor;
use App\Models\ArmadaVendor;

class VendorController extends Controller
{
    public function vendorView(){
        $regency = Regency::inRandomOrder()->first()->name;
        $vendors = Vendor::all();
        $armada_vendors = ArmadaVendor::all();
        $provinces = Province::all();
        return view('Masterdata.vendor',compact('provinces','vendors','armada_vendors'));
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
            $newVendor->email       = $request->email;
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
            $vendor->email       = $request->email;
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

    public function addArmadaVendor(Request $request){
        $name = strtoupper($request->armada_vendor_name);
        $check_name = ArmadaVendor::where('name', $name)->first();
        try {
            if($check_name != null){
                throw new \Exception('Vendor dengan nama '.$name.' sudah ada');
            }
            $armadavendor  = new ArmadaVendor;
            $armadavendor->name = $name;
            $armadavendor->save();
            return back()->with('success','Berhasil menambahkan vendor '.$name);
        } catch (\Exception $ex) {
            return back()->with('error','Gagal menambahkan armada vendor ('.$ex->getMessage().')');
        }
    }

    public function deleteArmadaVendor(Request $request){
        try{
            $vendor = ArmadaVendor::findOrFail($request->armada_vendor_id);
            $vendor->delete();

            return back()->with('success','Berhasil menghapus vendor');
        }catch (\Exception $ex) {
            return back()->with('error','Gagal menghapus Vendor  "'.$ex->getMessage().'"');
        }
    }
}
