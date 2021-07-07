<?php

namespace App\Http\Controllers\Masterdata;
use DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Armada;
use App\Models\Salespoint;

class ArmadaController extends Controller
{
    public function armadaView(){
        $armadas = Armada::all();
        $salespoints = Salespoint::all();
        return view('Masterdata.armada',compact('armadas','salespoints'));
    }

    public function addArmada(Request $request){
        try {
            $armadas_by_salespoint = Armada::where('salespoint_id',$request->salespoint_id)->get();
            foreach($armadas_by_salespoint as $armada){
                if($armada->name == $request->name){
                    throw new \Exception('Nama Armada di salespoint '.$armada->salespoint->name.' sudah ada ! ('.$armada->name.' -- '.$armada->plate.')');
                }
                
                if($armada->plate == $request->plate){
                    throw new \Exception('Nomor Pelat di salespoint '.$armada->salespoint->name.' sudah ada ! ('.$armada->name.' -- '.$armada->plate.')');
                }
            }
            DB::beginTransaction();
            $newArmada                  = new Armada;
            $newArmada->salespoint_id   = $request->salespoint_id; 
            $newArmada->name            = $request->name; 
            $newArmada->plate           = $request->plate; 
            $newArmada->status          = $request->status; 
            $newArmada->booked_by       = $request->booked_by ?? null; 
            $newArmada->isNiaga         = $request->isNiaga; 
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
            $armadas_by_salespoint = Armada::where('salespoint_id',$request->salespoint_id)
                                            ->where('id','!=',$request->armada_id)
                                            ->get();
            // dd($armadas_by_salespoint);
            foreach($armadas_by_salespoint as $armada){
                if($armada->name == $request->name){
                    throw new \Exception('Nama Armada di salespoint '.$armada->salespoint->name.' sudah ada !('.$armada->name.' -- '.$armada->plate.')');
                }
                
                if($armada->plate == $request->plate){
                    throw new \Exception('Nomor Pelat di salespoint '.$armada->salespoint->name.' sudah ada !('.$armada->name.' -- '.$armada->plate.')');
                }
            }
            DB::beginTransaction();
            $armada                  = Armada::find($request->armada_id);
            $armada->salespoint_id   = $request->salespoint_id; 
            $armada->name            = $request->name; 
            $armada->plate           = $request->plate; 
            $armada->status          = $request->status; 
            $armada->booked_by       = $request->booked_by ?? null; 
            $armada->isNiaga         = $request->isNiaga; 
            $armada->save();
            DB::commit();
            return back()->with('success','Berhasil update armada');
        } catch (\Exception $ex) {
            DB::rollback();
            return back()->with('error','Gagal update armada ('.$ex->getMessage().')');
        }
    }
}
