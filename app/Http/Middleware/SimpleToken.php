<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SimpleToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if($request->token == 'asdasdasd'){
                return $next($request);
            }
            return response()->json([
                'error' =>'Unauthenticated'
            ],401);
        } catch (\Throwable $th) {
            return response()->json([
                'error' =>'Authentication Failed'
            ],500);
        }
    }
}
