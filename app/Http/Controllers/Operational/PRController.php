<?php

namespace App\Http\Controllers\Operational;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PRController extends Controller
{
    public function prView(){
        return view('Operational.pr');
    }
}
