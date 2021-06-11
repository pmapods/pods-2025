<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class hasMenuAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $access)
    {
        $access = explode(':',$access);
        $menu_access = intval($access[1]);
        if($access[0] == 'masterdata'){
            $emp_access = intval(Auth::user()->menu_access->masterdata ?? 0);
            if(($emp_access & $menu_access) != 0){
                return $next($request);
            }else{
                return redirect('/dashboard')->with('error','Anda tidak memiliki access ke menu bersangkutan. Silahkan hubungi admin untuk mendapatkan akses');
            }
        }
        
        if($access[0] == 'operational'){
            $emp_access = intval(Auth::user()->menu_access->operational ?? 0);
            if(($emp_access & $menu_access) != 0){
                return $next($request);
            }else{
                return redirect('/dashboard')->with('error','Anda tidak memiliki access ke menu bersangkutan. Silahkan hubungi admin untuk mendapatkan akses');
            }
        }
    }
}
