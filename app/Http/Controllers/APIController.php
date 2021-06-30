<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function updateAssetNumber(Request $request){
        return response()->json([
            'success' => 'successfully access update asset number function'
        ],200);
    }
}
