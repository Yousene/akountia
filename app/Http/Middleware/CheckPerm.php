<?php

namespace App\Http\Middleware;

use Closure;

class CheckPerm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(!isset(\Auth::user()->role)){
            return $next($request);
        }

        if(\Auth::user()->role == 1 || \Auth::user()::hasRoute($request->route()->getName())){
            return $next($request);
        }        
        abort(403);
    }
}