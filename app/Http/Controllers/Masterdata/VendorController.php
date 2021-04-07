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
}
