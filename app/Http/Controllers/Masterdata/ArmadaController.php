<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Armada;

class ArmadaController extends Controller
{
    public function armadaView(){
        $armadas = Armada::all();
        return view('Masterdata.armada',compact('armadas'));
    }
}
