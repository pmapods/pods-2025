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

use App\Models\Employee;

class LoginController extends Controller
{
    public function loginView(){
        if(Auth::user()){
            return redirect('/dashboard');
        }
    	return view('Auth.login');
    }

    public function doLogin(Request $request){
        // validator
        // check via username
        $employee = Employee::where('username',$request->username)->first();
        if(!$employee){
            // check via email
            $employee = Employee::where('email',$request->username)->first();
        }
        if($employee){
            if(Hash::check($request->password, $employee->password)){
                Auth::login($employee);
                // check if already change password or not
                if($employee->is_password_changed){
                    return redirect('/dashboard')->with('success','Selamat datang '.$employee->name);
                }else{
                    return redirect('/changepassword');
                }
            }else{
                return back()->with('error','Password salah');
            }
        }else{
            return back()->with('error', 'Username atau email tidak terdaftar, silahkan coba kembali atau hubungi developer');
        }
    }

    public function updatePassword(Request $request){
        $employee = Auth::user();
        $employee->password =Hash::make($request->newpassword);
        $employee->is_password_changed = true;
        $employee->save();
        return redirect('/dashboard')->with('success','Berhasil mengubah kata sandi');
    }
}
