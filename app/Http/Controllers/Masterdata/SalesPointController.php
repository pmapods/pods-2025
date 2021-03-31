<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesPointController extends Controller
{
    public function salespointView(){
        return view('Masterdata.salespoint');
    }
}
