<?php

namespace App\Http\Controllers\Masterdata;
use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Armada;
use App\Models\ArmadaType;
use App\Models\Salespoint;

class ArmadaController extends Controller
{
    public function armadaView(){
        $armadas = Armada::all();
        $armada_types = ArmadaType::all();
        $salespoints = Salespoint::all();
        return view('Masterdata.armada',compact('armadas','salespoints','armada_types'));
    }

    public function addArmada(Request $request){
        try {
            $armada_by_plate = Armada::where('plate',strtoupper($request->plate))->first();
            if($armada_by_plate){
                throw new \Exception('Nomor Pelat sudah ada ! ('.$armada_by_plate->armada_type->name.' -- '.$armada_by_plate->plate.') di '.$armada_by_plate->salespoint->name);
            }
            DB::beginTransaction();
            $newArmada                  = new Armada;
            $newArmada->salespoint_id   = $request->salespoint_id;
            $newArmada->armada_type_id  = $request->armada_type_id;
            $newArmada->plate           = strtoupper($request->plate); 
            $newArmada->status          = $request->status; 
            $newArmada->booked_by       = $request->booked_by ?? null; 
            $newArmada->save();
            DB::commit();
            return back()->with('success','Berhasil menambahkan armada');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal menambahkan armada ('.$ex->getMessage().')');
        }

    }

    public function updateArmada(Request $request){
        try {
            $armada_by_plate = Armada::where('plate',strtoupper($request->plate))
                                        ->where('id','!=',$request->armada_id)
                                        ->first();
            if($armada_by_plate){
                throw new \Exception('Nomor Pelat sudah ada ! '.$armada_by_plate->armada_type->name.' -- '.$armada_by_plate->plate.' di '.$armada_by_plate->salespoint->name);
            }
            DB::beginTransaction();
            $armada                  = Armada::find($request->armada_id);
            $armada->salespoint_id   = $request->salespoint_id; 
            $armada->armada_type_id  = $request->armada_type_id; 
            $armada->plate           = strtoupper($request->plate); 
            $armada->status          = $request->status; 
            $armada->booked_by       = $request->booked_by ?? null; 
            $armada->save();
            DB::commit();
            return back()->with('success','Berhasil update armada');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal update armada ('.$ex->getMessage().')');
        }
    }

    public function deleteArmada(Request $request){
        try {
            $armada = Armada::findOrFail($request->armada_id);
            $armada->delete();
            return back()->with('success','Berhasil Menghapus Armada');
        } catch (\Exception $ex) {
            return back()->with('error','Gagal Menghapus Armada ('.$ex->getMessage().')');
        }
    }

    public function addArmadaType(Request $request){
        try {
            $armadatype = ArmadaType::where('name',$request->name)->first();
            if($armadatype){
                throw new \Exception('Nama Jenis Kendaraan sudah ada');
            }
            $newArmadatype = new ArmadaType;
            $newArmadatype->name = $request->name;
            $newArmadatype->brand_name = $request->brand_name;
            $newArmadatype->alias = $request->alias ?? null;
            $newArmadatype->isNiaga = $request->isNiaga;
            $newArmadatype->save();
            return back()->with('success','Berhasil Menambah Jenis Armada')->with('menu','armadatypelist');
        } catch (\Exception $ex) {
            return back()->with('error','Gagal Menambahkan Jenis Kendaraan ('.$ex->getMessage().')');
        }
    }
    
    public function deleteArmadaType(Request $request){
        try {
            $armadatype = ArmadaType::findOrFail($request->armada_type_id);
            if(count($armadatype->armada)>0){
                $plates = implode(", ",$armadatype->armada->pluck('plate')->toArray());
                throw new \Exception('Harap menghapus armada dengan nomor plat '.$plates.' sebelum melanjutkan pengahapusan jenis armada');
            }
            $armadatype->delete();
            return back()->with('success','Berhasil Menghapus Jenis Armada')->with('menu','armadatypelist');
        } catch (\Exception $ex) {
            return back()->with('error','Gagal Menghapus Jenis Kendaraan ('.$ex->getMessage().')');
        }
    }
}
