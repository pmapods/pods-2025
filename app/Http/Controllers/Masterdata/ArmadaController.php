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
}
