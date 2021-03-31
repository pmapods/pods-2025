<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Validator;
use Redirect;
use Crypt;
use Auth;
use Hash;
use DB;

class LoginController extends Controller
{
    public function loginView(){
    	return view('Auth.login');
    }

    public function doLogin(){
        return redirect('/dashboard');
    }

}
