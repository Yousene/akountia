<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {



            if(auth()->user()->role == '6' )
            {
                return redirect(RouteServiceProvider::HOME_COMMERCIAL);
            }elseif(auth()->user()->role == '5' || auth()->user()->role == '7' || auth()->user()->role == '8'){
                return redirect(RouteServiceProvider::HOME_PILOTAGE);
            }elseif(auth()->user()->role == '2' ){
                return redirect(RouteServiceProvider::HOME_LIVREUR);
            }elseif(auth()->user()->role == '3'){
                return redirect(RouteServiceProvider::HOME_Client);
            }else{
                return redirect(RouteServiceProvider::HOME);
            }

        }

        return $next($request);
    }
}
